<?php
declare(strict_types=1);

function load_config(): array
{
    $defaults = require ROOT_DIR . '/config.example.php';
    $file = ROOT_DIR . '/config.php';
    $local = is_file($file) ? require $file : [];
    return array_replace_recursive($defaults, is_array($local) ? $local : []);
}

/** Read a config value by dotted key, e.g. config('mail.to'). */
function config(string $key, $default = null)
{
    $value = $GLOBALS['config'];
    foreach (explode('.', $key) as $part) {
        if (!is_array($value) || !array_key_exists($part, $value)) {
            return $default;
        }
        $value = $value[$part];
    }
    return $value;
}

/** HTML-escape. */
function e(?string $s): string
{
    return htmlspecialchars((string) $s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Site URL path with the configured base path, e.g. url('/kontakt/'). */
function url(string $path = '/'): string
{
    return rtrim((string) config('base_path', ''), '/') . $path;
}

function redirect(string $location, int $status = 303): never
{
    header('Location: ' . $location, true, $status);
    exit;
}

function client_ip(): string
{
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function ensure_dir(string $dir): void
{
    if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
        throw new RuntimeException("Cannot create directory $dir");
    }
}

/** Write a file atomically (temp file + rename). */
function write_file_atomic(string $file, string $data): void
{
    ensure_dir(dirname($file));
    $tmp = $file . '.' . bin2hex(random_bytes(4)) . '.tmp';
    if (file_put_contents($tmp, $data, LOCK_EX) === false || !rename($tmp, $file)) {
        @unlink($tmp);
        throw new RuntimeException("Cannot write $file");
    }
}

/**
 * Simple file-based rate limit. Returns false when $max hits happened within $window seconds.
 */
function rate_limit(string $bucket, int $max, int $window, bool $hit = true): bool
{
    $file = RUNTIME_DIR . '/ratelimit/' . hash('sha256', $bucket . '|' . client_ip()) . '.json';
    ensure_dir(dirname($file));
    $now = time();
    $hits = is_file($file) ? (json_decode((string) file_get_contents($file), true) ?: []) : [];
    $hits = array_values(array_filter($hits, fn($t) => $t > $now - $window));
    if (count($hits) >= $max) {
        return false;
    }
    if ($hit) {
        $hits[] = $now;
        file_put_contents($file, json_encode($hits), LOCK_EX);
    }
    return true;
}

function rate_limit_reset(string $bucket): void
{
    @unlink(RUNTIME_DIR . '/ratelimit/' . hash('sha256', $bucket . '|' . client_ip()) . '.json');
}

/** "9. října 2026" from an ISO date. */
function cs_date(string $iso): string
{
    $m = ['', 'ledna', 'února', 'března', 'dubna', 'května', 'června', 'července', 'srpna', 'září', 'října', 'listopadu', 'prosince'];
    $t = strtotime($iso);
    return $t ? (int) date('j', $t) . '. ' . $m[(int) date('n', $t)] . ' ' . date('Y', $t) : '';
}

/** Smaller variant of an image (name-640.webp) when it exists next to the original, else the original. */
function img_small(string $src): string
{
    $small = preg_replace('/\.(webp|jpe?g|png)$/i', '-640.$1', $src);
    return $small !== $src && is_file(PUBLIC_DIR . $small) ? $small : $src;
}

/** Paragraphs from a rich field: blocks separated by two <br>. */
function rich_paragraphs(string $html): array
{
    $parts = preg_split('~(?:<br\s*/?>\s*){2,}~i', trim($html)) ?: [];
    return array_values(array_filter(array_map('trim', $parts), fn($p) => $p !== ''));
}

/** Bullet items from a text field: one per line. */
function text_lines(string $text): array
{
    return array_values(array_filter(array_map('trim', explode("\n", $text)), fn($l) => $l !== ''));
}

/** Body blocks ("blok-*" sections) of a page, visible only: [{h, paragraphs[], items[]}] */
function body_blocks(array $page): array
{
    $out = [];
    foreach ($page['sections'] as $s) {
        if (!str_starts_with($s['key'], 'blok-') || empty($s['visible'])) {
            continue;
        }
        $f = [];
        foreach ($s['fields'] as $field) {
            $f[$field['key']] = $field['value'];
        }
        $out[] = ['id' => preg_match('/^blok-\d+$/', $s['key']) ? $s['key'] : substr($s['key'], 5), 'h' => (string) ($f['t1'] ?? ''), 'h3' => (string) ($f['t3'] ?? ''), 'paragraphs' => rich_paragraphs((string) ($f['r1'] ?? '')), 'items' => text_lines((string) ($f['t2'] ?? ''))];
    }
    return $out;
}
