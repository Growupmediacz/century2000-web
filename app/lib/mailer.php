<?php
/*
 * Minimal mailer with attachments. Transports (config mail.transport):
 *   mail – PHP mail() (default on Webglobe)
 *   smtp – login to a mailbox (SSL 465 or STARTTLS 587)
 *   log  – write .eml files to content/.runtime/mail (local testing)
 */
declare(strict_types=1);

/**
 * @param array $mail {to, subject, text, reply_to?, attachments?: [{name, type, data}]}
 */
function send_mail(array $mail): void
{
    $from = (string) config('mail.from');
    $fromName = (string) config('mail.from_name');
    $boundary = 'c2000-' . bin2hex(random_bytes(12));

    $headers = [
        'From' => mime_header($fromName) . " <$from>",
        'Reply-To' => $mail['reply_to'] ?? $from,
        'MIME-Version' => '1.0',
        'Content-Type' => "multipart/mixed; boundary=\"$boundary\"",
        'X-Mailer' => 'Century2000-Web',
    ];
    $body = "--$boundary\r\n"
        . "Content-Type: text/plain; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n"
        . chunk_split(base64_encode($mail['text'])) . "\r\n";
    foreach ($mail['attachments'] ?? [] as $a) {
        $name = mime_header($a['name']);
        $body .= "--$boundary\r\n"
            . "Content-Type: {$a['type']}; name=\"$name\"\r\n"
            . "Content-Transfer-Encoding: base64\r\n"
            . "Content-Disposition: attachment; filename=\"$name\"\r\n\r\n"
            . chunk_split(base64_encode($a['data'])) . "\r\n";
    }
    $body .= "--$boundary--\r\n";
    $subject = mime_header($mail['subject']);

    switch (config('mail.transport')) {
        case 'log':
            $headerText = '';
            foreach ($headers as $k => $v) {
                $headerText .= "$k: $v\r\n";
            }
            $file = RUNTIME_DIR . '/mail/' . date('Y-m-d_H-i-s') . '_' . bin2hex(random_bytes(3)) . '.eml';
            ensure_dir(dirname($file));
            file_put_contents($file, "To: {$mail['to']}\r\nSubject: $subject\r\n$headerText\r\n$body");
            return;
        case 'smtp':
            smtp_send($from, $mail['to'], $subject, $headers, $body);
            return;
        default:
            $headerText = '';
            foreach ($headers as $k => $v) {
                $headerText .= "$k: $v\r\n";
            }
            if (!mail($mail['to'], $subject, $body, rtrim($headerText), '-f' . $from)) {
                throw new RuntimeException('mail() failed');
            }
    }
}

function mime_header(string $s): string
{
    return preg_match('/[^\x20-\x7e]/', $s) ? '=?UTF-8?B?' . base64_encode($s) . '?=' : $s;
}

function smtp_send(string $from, string $to, string $subject, array $headers, string $body): void
{
    $c = config('mail.smtp');
    $secure = $c['secure'] ?? 'ssl';
    $host = ($secure === 'ssl' ? 'ssl://' : 'tcp://') . $c['host'] . ':' . (int) $c['port'];
    $s = @stream_socket_client($host, $errno, $errstr, 20);
    if (!$s) {
        throw new RuntimeException("SMTP connect failed: $errstr");
    }
    stream_set_timeout($s, 20);
    $expect = function (string $codes) use ($s): string {
        $resp = '';
        while (($line = fgets($s, 1024)) !== false) {
            $resp .= $line;
            if (strlen($line) < 4 || $line[3] === ' ') {
                break;
            }
        }
        if (!in_array(substr($resp, 0, 3), explode(',', $codes), true)) {
            throw new RuntimeException('SMTP error: ' . trim($resp));
        }
        return $resp;
    };
    $cmd = function (string $line, string $codes) use ($s, $expect): string {
        fwrite($s, $line . "\r\n");
        return $expect($codes);
    };
    $helo = preg_replace('/[^a-z0-9.-]/i', '', $_SERVER['SERVER_NAME'] ?? 'localhost') ?: 'localhost';
    $expect('220');
    $cmd("EHLO $helo", '250');
    if ($secure === 'tls') {
        $cmd('STARTTLS', '220');
        if (!stream_socket_enable_crypto($s, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
            throw new RuntimeException('STARTTLS failed');
        }
        $cmd("EHLO $helo", '250');
    }
    $cmd('AUTH LOGIN', '334');
    $cmd(base64_encode((string) $c['user']), '334');
    $cmd(base64_encode((string) $c['password']), '235');
    $cmd("MAIL FROM:<$from>", '250');
    $cmd("RCPT TO:<$to>", '250,251');
    $cmd('DATA', '354');
    $data = "To: $to\r\nSubject: $subject\r\nDate: " . date('r') . "\r\n";
    foreach ($headers as $k => $v) {
        $data .= "$k: $v\r\n";
    }
    $data .= "\r\n" . preg_replace('/^\./m', '..', $body);
    fwrite($s, $data . "\r\n.\r\n");
    $expect('250');
    $cmd('QUIT', '221');
    fclose($s);
}
