<?php
/*
 * Administration (/admin/): login, list of pages, content editor, history of versions.
 * Pages are edited as sections of fields defined in content/*.json:
 *   text  – plain text,  rich – text with bold/italic/links,  image – upload + alt text
 * and every hideable section has a "show on the web" switch.
 */
declare(strict_types=1);

const ADMIN_IDLE = 4 * 3600;
const IMAGE_MAX_UPLOAD = 20 * 1024 * 1024;
const IMAGE_MAX_SIDE = 2400;

function admin_handle(): void
{
    header('X-Frame-Options: DENY');
    header('X-Robots-Tag: noindex, nofollow');
    header('Cache-Control: no-store');
    admin_session_start();

    $action = (string) ($_GET['a'] ?? 'pages');
    if (!admin_configured()) {
        admin_view('setup', ['title' => 'Administrace není nastavená']);
        return;
    }
    if ($action === 'login') {
        admin_login();
        return;
    }
    if (!admin_logged_in()) {
        redirect(admin_url('login'));
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        csrf_check();
    }
    match ($action) {
        'logout' => admin_logout(),
        'edit' => admin_edit(),
        'save' => admin_save(),
        'history' => admin_history(),
        'restore' => admin_restore(),
        'new' => admin_new(),
        default => admin_pages(),
    };
}

// ---------------------------------------------------------------- session, auth, CSRF

function admin_session_start(): void
{
    $https = ($_SERVER['HTTPS'] ?? '') !== '' && $_SERVER['HTTPS'] !== 'off';
    session_name('c2000admin');
    session_set_cookie_params(['path' => url('/admin/'), 'httponly' => true, 'samesite' => 'Strict', 'secure' => $https]);
    session_start();
    if (isset($_SESSION['seen']) && time() - $_SESSION['seen'] > ADMIN_IDLE) {
        $_SESSION = [];
        session_regenerate_id(true);
    }
    $_SESSION['seen'] = time();
}

function admin_configured(): bool
{
    return (string) config('admin.password_hash') !== '';
}

function admin_logged_in(): bool
{
    return !empty($_SESSION['admin']);
}

function csrf_token(): string
{
    return $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_check(): void
{
    if (!hash_equals(csrf_token(), (string) ($_POST['csrf'] ?? ''))) {
        http_response_code(400);
        exit('Neplatný požadavek. Obnovte stránku a zkuste to znovu.');
    }
}

function admin_url(string $action = 'pages', array $params = []): string
{
    return url('/admin/') . '?' . http_build_query(['a' => $action] + $params);
}

function flash(?string $message = null, string $type = 'ok'): ?array
{
    if ($message !== null) {
        $_SESSION['flash'] = [$type, $message];
        return null;
    }
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}

function admin_login(): void
{
    $error = null;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        csrf_check();
        if (!rate_limit('login', 5, 900, false)) {
            $error = 'Příliš mnoho neúspěšných pokusů. Zkuste to znovu za 15 minut.';
        } elseif (hash_equals((string) config('admin.user'), (string) ($_POST['user'] ?? ''))
            && password_verify((string) ($_POST['password'] ?? ''), (string) config('admin.password_hash'))) {
            rate_limit_reset('login');
            session_regenerate_id(true);
            $_SESSION['admin'] = true;
            unset($_SESSION['csrf']);
            redirect(admin_url());
        } else {
            rate_limit('login', 5, 900);
            $error = 'Nesprávné jméno nebo heslo.';
        }
    }
    admin_view('login', ['title' => 'Přihlášení', 'error' => $error]);
}

function admin_logout(): void
{
    $_SESSION = [];
    session_regenerate_id(true);
    redirect(admin_url('login'));
}

// ---------------------------------------------------------------- pages

/** Order of pages in the admin (menu order first, then system pages). */
const ADMIN_ORDER = ['index', 'bytovy-textil-na-miru', 'hotelovy-textil', 'strojni-prosivani', 'matracove-chranice-a-potahy',
    'latky-a-metraz', 'reference', 'o-nas', 'kariera', 'kontakt', 'global'];

/** Editable documents in admin order: name => {label, path|null, sections, main}. */
function admin_documents(): array
{
    $docs = [];
    foreach (content_pages() as $name => $page) {
        if (!empty($page['editable'])) {
            $docs[(string) $name] = ['label' => $page['name'], 'path' => $page['path'], 'sections' => count($page['sections']),
                'group' => match ($page['options']['type'] ?? '') { 'article' => 'articles', 'reference' => 'references', default => '' }];
        }
    }
    $docs['global'] = ['label' => 'Patička (na všech stránkách)', 'path' => null, 'sections' => 1, 'group' => ''];
    $rank = array_flip(ADMIN_ORDER);
    uksort($docs, fn($a, $b) => [$rank[$a] ?? 99, $a] <=> [$rank[$b] ?? 99, $b]);
    foreach ($docs as $name => &$doc) {
        $doc['main'] = isset($rank[$name]);
    }
    return $docs;
}

function admin_document(string $name): array
{
    $docs = admin_documents();
    if (!isset($docs[$name])) {
        http_response_code(404);
        exit('Stránka nenalezena.');
    }
    return [$docs[$name], content_load($name)];
}

/** Slug from a Czech title: "Látky na ubrusy!" → "latky-na-ubrusy". */
function slugify(string $title): string
{
    $s = mb_strtolower($title);
    $s = strtr($s, ['á' => 'a', 'č' => 'c', 'ď' => 'd', 'é' => 'e', 'ě' => 'e', 'í' => 'i', 'ň' => 'n', 'ó' => 'o',
                    'ř' => 'r', 'š' => 's', 'ť' => 't', 'ú' => 'u', 'ů' => 'u', 'ý' => 'y', 'ž' => 'z']);
    return mb_substr(trim(preg_replace('/[^a-z0-9]+/', '-', $s) ?? '', '-'), 0, 70);
}

/** Create a new article or reference from a skeleton and open it in the editor. */
function admin_new(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect(admin_url());
    }
    $type = (string) ($_POST['type'] ?? '');
    $title = clean_text((string) ($_POST['title'] ?? ''), 120);
    $slug = slugify($title);
    if (!in_array($type, ['article', 'reference'], true) || $slug === '') {
        flash('Zadejte název (písmena a číslice).', 'error');
        redirect(admin_url());
    }
    $isArticle = $type === 'article';
    $prefix = $isArticle ? 'clanek-' : 'realizace-';
    $dir = $isArticle ? '/clanky/' : '/reference/';
    if (is_file(content_file($prefix . $slug)) || page_by_path($dir . $slug . '/') !== null) {
        flash('Stránka s takovým názvem už existuje.', 'error');
        redirect(admin_url());
    }
    $f = fn(string $k, string $type, string $label, $value) => ['key' => $k, 'type' => $type, 'label' => $label, 'value' => $value];
    $img = ['src' => '/assets/fotky/textura-prosev.webp', 'alt' => ''];
    $today = date('Y-m-d');
    if ($isArticle) {
        $sections = [
            ['key' => 'hlavicka', 'label' => 'Hlavička článku', 'hideable' => false, 'visible' => true, 'fields' => [
                $f('t1', 'text', 'Nadpis (H1)', $title), $f('t2', 'text', 'Perex', ''), $f('img1', 'image', 'Hlavní obrázek', $img)]],
        ];
        foreach ([1, 2, 3] as $n) {
            $sections[] = ['key' => "blok-$n", 'label' => "Odstavec $n", 'hideable' => true, 'visible' => $n === 1, 'fields' => [
                $f('t1', 'text', 'Mezititulek (H2)', ''), $f('r1', 'rich', 'Text (odstavce oddělte prázdným řádkem)', ''), $f('t2', 'text', 'Odrážky (každá na nový řádek)', '')]];
        }
        $sections[] = ['key' => 'souvisejici-sluzba', 'label' => 'Související služba a výzva', 'hideable' => true, 'visible' => true, 'fields' => [
            $f('t1', 'text', 'Štítek', 'Související služba'), $f('t2', 'text', 'Nadpis', 'Bytový textil na míru'),
            $f('t3', 'text', 'Text', 'Závěsy, záclony, rolety, japonské stěny a přehozy šité podle vašich rozměrů.'),
            $f('t4', 'text', 'Odkaz (adresa)', '/bytovy-textil-na-miru/'), $f('t5', 'text', 'Odkaz (text)', 'Bytový textil →')]];
        $page = ['path' => "/clanky/$slug/", 'name' => $title, 'editable' => true, 'meta' => ['title' => mb_substr($title, 0, 45) . ' | Century 2000', 'description' => ''],
            'options' => ['type' => 'article', 'template' => 'clanek', 'date' => $today, 'modified' => $today, 'order' => 0, 'image' => $img['src'], 'css' => ['obsah']], 'sections' => $sections];
        // newest first: "order" 0 would sort first; drop it so the list sorts by date
        unset($page['options']['order']);
    } else {
        $page = ['path' => "/reference/$slug/", 'name' => $title, 'editable' => true, 'meta' => ['title' => mb_substr($title, 0, 40) . ': reference | Century 2000', 'description' => ''],
            'options' => ['type' => 'reference', 'template' => 'realizace', 'order' => 50, 'featured' => false, 'image' => $img['src'], 'css' => ['obsah']],
            'sections' => [
                ['key' => 'hlavicka', 'label' => 'Hlavička', 'hideable' => false, 'visible' => true, 'fields' => [
                    $f('t1', 'text', 'Název (H1)', $title), $f('t2', 'text', 'Místo', ''), $f('img1', 'image', 'Hlavní fotografie', $img)]],
                ['key' => 'popis', 'label' => 'Popis realizace', 'hideable' => false, 'visible' => true, 'fields' => [
                    $f('t1', 'text', 'Co jsme šili (položky oddělte čárkou)', ''), $f('t2', 'text', 'Popis', ''), $f('t3', 'text', 'Poznámka o spolupráci', '')]],
                ['key' => 'galerie', 'label' => 'Fotogalerie', 'hideable' => true, 'visible' => true, 'fields' => array_map(
                    fn($n) => $f("img$n", 'image', "Fotografie $n", $img), range(1, 4))],
            ]];
    }
    content_save($prefix . $slug, $page);
    flash('Stránka je vytvořená. Doplňte texty a obrázky, poté ji uvidíte na webu.');
    redirect(admin_url('edit', ['page' => $prefix . $slug]));
}

function admin_pages(): void
{
    admin_view('pages', ['title' => 'Stránky webu', 'docs' => admin_documents()]);
}

function admin_edit(): void
{
    $name = (string) ($_GET['page'] ?? '');
    [$doc, $data] = admin_document($name);
    admin_view('edit', ['title' => $doc['label'], 'name' => $name, 'doc' => $doc, 'data' => $data,
                        'version' => (string) filemtime(content_file($name))]);
}

function admin_save(): void
{
    $name = (string) ($_GET['page'] ?? '');
    [, $data] = admin_document($name);

    if ((string) ($_POST['version'] ?? '') !== (string) filemtime(content_file($name))) {
        flash('Stránku mezitím upravil někdo jiný (nebo jiné okno). Vaše změny nebyly uloženy – načetla se aktuální verze.', 'error');
        redirect(admin_url('edit', ['page' => $name]));
    }

    if (isset($data['meta'])) {
        $data['meta']['title'] = clean_text((string) ($_POST['meta']['title'] ?? $data['meta']['title']), 200);
        $data['meta']['description'] = clean_text((string) ($_POST['meta']['description'] ?? $data['meta']['description']), 400);
    }
    $errors = [];
    foreach ($data['sections'] as &$section) {
        $sk = $section['key'];
        if (!empty($section['hideable']) && isset($_POST['visible'][$sk])) {
            $section['visible'] = $_POST['visible'][$sk] === '1';
        }
        foreach ($section['fields'] as &$field) {
            $fk = $field['key'];
            switch ($field['type']) {
                case 'text':
                    if (isset($_POST['f'][$sk][$fk])) {
                        $field['value'] = clean_text((string) $_POST['f'][$sk][$fk], 3000);
                    }
                    break;
                case 'rich':
                    if (isset($_POST['f'][$sk][$fk])) {
                        $field['value'] = sanitize_rich((string) $_POST['f'][$sk][$fk]);
                    }
                    break;
                case 'image':
                    if (isset($_POST['alt'][$sk][$fk])) {
                        $field['value']['alt'] = clean_text((string) $_POST['alt'][$sk][$fk], 300);
                    }
                    $upload = uploaded_file('img', $sk, $fk);
                    if ($upload) {
                        try {
                            $field['value']['src'] = save_uploaded_image($upload);
                        } catch (RuntimeException $ex) {
                            $errors[] = "{$section['label']} – {$field['label']}: " . $ex->getMessage();
                        }
                    }
                    break;
            }
        }
        unset($field);
    }
    unset($section);

    content_save($name, $data);
    if ($errors) {
        flash("Uloženo, ale některé obrázky se nepodařilo nahrát:\n" . implode("\n", $errors), 'error');
    } else {
        flash('Změny jsou uložené a na webu.');
    }
    redirect(admin_url('edit', ['page' => $name]));
}

function admin_history(): void
{
    $name = (string) ($_GET['page'] ?? '');
    [$doc] = admin_document($name);
    admin_view('history', ['title' => 'Historie: ' . $doc['label'], 'name' => $name, 'doc' => $doc,
                           'backups' => content_backups($name)]);
}

function admin_restore(): void
{
    $name = (string) ($_GET['page'] ?? '');
    admin_document($name);
    content_restore($name, (string) ($_POST['backup'] ?? ''));
    flash('Obnovena předchozí verze. (Verze před obnovením je uložená v historii.)');
    redirect(admin_url('edit', ['page' => $name]));
}

// ---------------------------------------------------------------- input cleaning

function clean_text(string $s, int $max): string
{
    $s = str_replace(["\r\n", "\r"], "\n", $s);
    $s = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $s) ?? '';
    return mb_substr(trim($s), 0, $max);
}

/**
 * Allow only simple inline formatting: bold, italic, line break, links, and the design's highlight marks.
 * Everything else is unwrapped to text.
 */
function sanitize_rich(string $html): string
{
    $html = trim($html);
    if ($html === '') {
        return '';
    }
    $doc = new DOMDocument();
    $prev = libxml_use_internal_errors(true);
    $doc->loadHTML('<?xml encoding="utf-8"?><div id="rich-root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    libxml_use_internal_errors($prev);
    $root = $doc->getElementById('rich-root');
    if (!$root) {
        return e(strip_tags($html));
    }
    sanitize_node($root);
    $out = '';
    foreach (iterator_to_array($root->childNodes) as $child) {
        $out .= $doc->saveHTML($child);
    }
    $out = preg_replace('/(<br>\s*)+$/', '', trim($out)) ?? '';
    return mb_substr($out, 0, 20000);
}

function sanitize_node(DOMNode $node): void
{
    $rename = ['b' => 'strong', 'i' => 'em'];
    $allowed = ['strong' => [], 'em' => [], 'br' => [], 'a' => ['href', 'target', 'rel', 'class'], 'mark' => ['class'], 'span' => ['class']];
    $blocks = ['div', 'p', 'li', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote'];

    foreach (iterator_to_array($node->childNodes) as $child) {
        if ($child instanceof DOMText) {
            continue;
        }
        if (!$child instanceof DOMElement) {
            $node->removeChild($child);
            continue;
        }
        $tag = strtolower($child->tagName);
        if (isset($rename[$tag])) {
            $new = $child->ownerDocument->createElement($rename[$tag]);
            while ($child->firstChild) {
                $new->appendChild($child->firstChild);
            }
            $node->replaceChild($new, $child);
            $child = $new;
            $tag = $rename[$tag];
        }
        if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed', 'template'], true)) {
            $node->removeChild($child);
            continue;
        }
        sanitize_node($child);
        if (!isset($allowed[$tag])) {
            // unwrap; block elements become line breaks
            $isBlock = in_array($tag, $blocks, true);
            if ($isBlock && $child->previousSibling) {
                $node->insertBefore($child->ownerDocument->createElement('br'), $child);
            }
            while ($child->firstChild) {
                $node->insertBefore($child->firstChild, $child);
            }
            $node->removeChild($child);
            continue;
        }
        foreach (iterator_to_array($child->attributes) as $attr) {
            $an = strtolower($attr->name);
            $ok = in_array($an, $allowed[$tag], true);
            if ($ok && $an === 'href') {
                $ok = (bool) preg_match('~^(https?://|mailto:|tel:|/|#)~i', trim($attr->value));
            }
            if ($ok && $an === 'class') {
                $ok = (bool) preg_match('/^[a-z0-9_ -]+$/i', $attr->value);
            }
            if ($ok && $an === 'target') {
                $ok = $attr->value === '_blank';
            }
            if (!$ok) {
                $child->removeAttribute($attr->name);
            }
        }
        if ($tag === 'a' && $child->getAttribute('target') === '_blank') {
            $child->setAttribute('rel', 'noopener');
        }
        if (in_array($tag, ['span', 'mark'], true) && !$child->hasAttributes()) {
            while ($child->firstChild) {
                $node->insertBefore($child->firstChild, $child);
            }
            $node->removeChild($child);
        }
    }
}

// ---------------------------------------------------------------- images

/** $_FILES['img']['…'][$section][$field] → single file array, or null. */
function uploaded_file(string $input, string $section, string $field): ?array
{
    $f = $_FILES[$input] ?? null;
    if (!$f || !isset($f['error'][$section][$field]) || $f['error'][$section][$field] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    return [
        'name' => $f['name'][$section][$field], 'tmp_name' => $f['tmp_name'][$section][$field],
        'error' => $f['error'][$section][$field], 'size' => $f['size'][$section][$field],
    ];
}

/** Validate, auto-rotate, shrink and convert an uploaded photo to WebP. Returns its URL path. */
function save_uploaded_image(array $file): string
{
    if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE || $file['size'] > IMAGE_MAX_UPLOAD) {
        throw new RuntimeException('soubor je příliš velký (max. 20 MB).');
    }
    if ($file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
        throw new RuntimeException('nahrání selhalo, zkuste to znovu.');
    }
    $info = @getimagesize($file['tmp_name']);
    $type = $info[2] ?? 0;
    $img = match ($type) {
        IMAGETYPE_JPEG => @imagecreatefromjpeg($file['tmp_name']),
        IMAGETYPE_PNG => @imagecreatefrompng($file['tmp_name']),
        IMAGETYPE_WEBP => @imagecreatefromwebp($file['tmp_name']),
        IMAGETYPE_GIF => @imagecreatefromgif($file['tmp_name']),
        default => false,
    };
    if (!$img) {
        throw new RuntimeException('nepodporovaný formát. Použijte fotku ve formátu JPG, PNG nebo WebP.');
    }
    if ($type === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
        $orientation = (int) (@exif_read_data($file['tmp_name'])['Orientation'] ?? 1);
        $rotated = match ($orientation) { 3 => imagerotate($img, 180, 0), 6 => imagerotate($img, -90, 0), 8 => imagerotate($img, 90, 0), default => null };
        if ($rotated) {
            imagedestroy($img);
            $img = $rotated;
        }
    }
    $w = imagesx($img);
    $h = imagesy($img);
    $scale = min(1, IMAGE_MAX_SIDE / max($w, $h));
    if ($scale < 1) {
        $resized = imagecreatetruecolor((int) round($w * $scale), (int) round($h * $scale));
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        imagecopyresampled($resized, $img, 0, 0, 0, 0, imagesx($resized), imagesy($resized), $w, $h);
        imagedestroy($img);
        $img = $resized;
    } else {
        imagepalettetotruecolor($img);
        imagealphablending($img, false);
        imagesavealpha($img, true);
    }

    $base = mb_strtolower(pathinfo((string) $file['name'], PATHINFO_FILENAME));
    $base = strtr($base, ['á' => 'a', 'č' => 'c', 'ď' => 'd', 'é' => 'e', 'ě' => 'e', 'í' => 'i', 'ň' => 'n', 'ó' => 'o',
                          'ř' => 'r', 'š' => 's', 'ť' => 't', 'ú' => 'u', 'ů' => 'u', 'ý' => 'y', 'ž' => 'z', 'ä' => 'a', 'ö' => 'o', 'ü' => 'u']);
    $base = trim(preg_replace('/[^a-z0-9]+/', '-', $base) ?? '', '-') ?: 'foto';
    $rel = '/uploads/' . date('Y/m') . '/' . mb_substr($base, 0, 50) . '-' . bin2hex(random_bytes(3));
    ensure_dir(PUBLIC_DIR . dirname($rel . '.x'));
    if (function_exists('imagewebp') && imagewebp($img, PUBLIC_DIR . $rel . '.webp', 82)) {
        $rel .= '.webp';
    } elseif (imagejpeg($img, PUBLIC_DIR . $rel . '.jpg', 85)) {
        $rel .= '.jpg';
    } else {
        throw new RuntimeException('obrázek se nepodařilo uložit.');
    }
    imagedestroy($img);
    return $rel;
}

// ---------------------------------------------------------------- views

function admin_view(string $view, array $vars): void
{
    extract($vars);
    $flash = flash();
    include APP_DIR . '/admin/views/layout.php';
}

function admin_partial(string $view, array $vars): void
{
    extract($vars);
    include APP_DIR . "/admin/views/$view.php";
}
