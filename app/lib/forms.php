<?php
/*
 * Form submissions: POST /odeslat/poptavka and /odeslat/kariera.
 * Spam protection: hidden honeypot field, signed time token (min. 3 s to fill in), rate limit per IP.
 * The browser validates first (assets/js/site.js); the same rules are checked here.
 */
declare(strict_types=1);

const FORM_MAX_FILE = 10 * 1024 * 1024;
const FORM_FILE_TYPES = [
    'pdf' => 'application/pdf', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp',
    'heic' => 'image/heic', 'doc' => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'xls' => 'application/vnd.ms-excel', 'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'dwg' => 'application/acad', 'dxf' => 'application/dxf',
];

const FORMS = [
    'poptavka' => [
        'thanks' => '/dekujeme/',
        'to' => 'mail.to',
        'fields' => ['service' => 'Služba', 'name' => 'Jméno a příjmení', 'email' => 'E-mail', 'phone' => 'Telefon',
                     'company' => 'Firma', 'message' => 'Co potřebuje'],
        'required' => ['name', 'email', 'message'],
    ],
    'kariera' => [
        'thanks' => '/dekujeme-kariera/',
        'to' => 'mail.to_career',
        'fields' => ['position' => 'Pozice', 'name' => 'Jméno a příjmení', 'phone' => 'Telefon', 'email' => 'E-mail',
                     'about' => 'O uchazeči'],
        'required' => ['name', 'phone'],
    ],
];

/** Hidden fields added to every form (honeypot + signed timestamp). */
function form_token(): string
{
    $ts = (string) time();
    return $ts . '.' . hash_hmac('sha256', $ts, form_secret());
}

function form_secret(): string
{
    $secret = (string) config('secret');
    if ($secret === '') {
        // Fallback for a missing config.php: stable per installation.
        $file = RUNTIME_DIR . '/secret';
        if (!is_file($file)) {
            ensure_dir(RUNTIME_DIR);
            file_put_contents($file, bin2hex(random_bytes(32)));
        }
        $secret = (string) file_get_contents($file);
    }
    return $secret;
}

function form_token_valid(string $token): bool
{
    [$ts, $sig] = array_pad(explode('.', $token, 2), 2, '');
    if (!ctype_digit($ts) || !hash_equals(hash_hmac('sha256', $ts, form_secret()), $sig)) {
        return false;
    }
    $age = time() - (int) $ts;
    return $age >= 3 && $age <= 86400;
}

function handle_form(string $type): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        redirect(url('/'), 303);
    }
    $form = FORMS[$type];
    $back = form_back_url();

    // Bots: fill the honeypot or submit instantly. Pretend success, send nothing.
    if (($_POST['web'] ?? '') !== '' || !form_token_valid((string) ($_POST['token'] ?? ''))) {
        redirect(url($form['thanks']));
    }
    if (!rate_limit('form', 5, 600)) {
        redirect($back . 'chyba=limit#formular-chyba');
    }

    $values = [];
    foreach ($form['fields'] as $k => $_) {
        $values[$k] = trim(str_replace("\r\n", "\n", (string) ($_POST[$k] ?? '')));
        $values[$k] = mb_substr($values[$k], 0, $k === 'message' || $k === 'about' ? 5000 : 200);
    }
    $errors = [];
    foreach ($form['required'] as $k) {
        if ($values[$k] === '') {
            $errors[] = $k;
        }
    }
    if ($values['email'] !== '' && !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'email';
    }

    $attachments = [];
    $file = $_FILES['attachment'] ?? null;
    if ($file && ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
        $ext = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));
        if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > FORM_MAX_FILE || !isset(FORM_FILE_TYPES[$ext])) {
            $errors[] = 'file';
        } else {
            $name = preg_replace('/[^\w.\- ]+/u', '_', basename((string) $file['name']));
            $attachments[] = ['name' => $name, 'type' => FORM_FILE_TYPES[$ext], 'data' => (string) file_get_contents($file['tmp_name'])];
        }
    }
    if ($errors) {
        redirect($back . 'chyba=' . implode(',', array_unique($errors)) . '#formular-chyba');
    }

    $lines = [];
    foreach ($form['fields'] as $k => $label) {
        if ($values[$k] !== '') {
            $lines[] = str_contains($values[$k], "\n") ? "$label:\n{$values[$k]}\n" : "$label: {$values[$k]}";
        }
    }
    $text = implode("\n", $lines)
        . "\n\n—\nOdesláno z webu " . rtrim((string) config('site_url'), '/') . ' ' . date('j. n. Y H:i')
        . ($attachments ? "\nPříloha: " . $attachments[0]['name'] : '');
    $subject = $type === 'poptavka'
        ? 'Poptávka z webu' . ($values['service'] ? " – {$values['service']}" : '') . " – {$values['name']}"
        : 'Zájem o práci' . ($values['position'] ? " – {$values['position']}" : '') . " – {$values['name']}";

    try {
        send_mail([
            'to' => (string) config($form['to']),
            'subject' => $subject,
            'text' => $text,
            'reply_to' => filter_var($values['email'], FILTER_VALIDATE_EMAIL) ? $values['email'] : null,
            'attachments' => $attachments,
        ]);
    } catch (Throwable $ex) {
        error_log('Century2000 form mail failed: ' . $ex->getMessage());
        redirect($back . 'chyba=odeslani#formular-chyba');
    }
    redirect(url($form['thanks']));
}

/** The page the form was sent from (same site only), ready for "?…" or "&…". */
function form_back_url(): string
{
    $ref = (string) ($_SERVER['HTTP_REFERER'] ?? '');
    $host = (string) ($_SERVER['HTTP_HOST'] ?? '');
    $path = url('/kontakt/');
    if ($ref !== '' && parse_url($ref, PHP_URL_HOST) === explode(':', $host)[0]) {
        $path = (string) parse_url($ref, PHP_URL_PATH);
    }
    return $path . '?';
}
