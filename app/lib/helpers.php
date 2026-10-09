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

/**
 * Body blocks of a page, visible only, in order. Section keys:
 *   blok-*  text block   {type: text, id, h, paragraphs[], items[]}
 *   foto-*  figure       {type: figure, id, src, alt, caption}
 *   tip-*   callout box  {type: tip, id, h, paragraphs[]}
 * $only limits the result to one type (e.g. 'text' for the fabric details on Látky a metráž).
 */
function body_blocks(array $page, ?string $only = null): array
{
    $out = [];
    foreach ($page['sections'] as $s) {
        if (empty($s['visible']) || !preg_match('/^(blok|foto|tip)-/', $s['key'], $m)) {
            continue;
        }
        $f = [];
        foreach ($s['fields'] as $field) {
            $f[$field['key']] = $field['value'];
        }
        $id = preg_match('/^[a-z]+-\d+$/', $s['key']) ? $s['key'] : substr($s['key'], strlen($m[1]) + 1);
        if ($m[1] === 'foto') {
            $img = $f['img1'] ?? ['src' => '', 'alt' => ''];
            $b = ['type' => 'figure', 'id' => $id, 'src' => (string) ($img['src'] ?? ''), 'alt' => (string) ($img['alt'] ?? ''), 'caption' => (string) ($f['t1'] ?? '')];
        } elseif ($m[1] === 'tip') {
            $b = ['type' => 'tip', 'id' => $id, 'h' => (string) ($f['t1'] ?? ''), 'paragraphs' => rich_paragraphs((string) ($f['r1'] ?? ''))];
        } else {
            $b = ['type' => 'text', 'id' => $id, 'h' => (string) ($f['t1'] ?? ''), 'paragraphs' => rich_paragraphs((string) ($f['r1'] ?? '')), 'items' => text_lines((string) ($f['t2'] ?? ''))];
        }
        if ($only === null || $only === $b['type']) {
            $out[] = $b;
        }
    }
    return $out;
}

/** Articles for a teaser: those whose options.service equals $service (newest first), or the latest ones. */
function articles_for(?string $service, int $limit = 3, ?string $exclude = null): array
{
    $list = [];
    foreach (pages_of_type('article') as $p) {
        if ($exclude !== null && $p['path'] === $exclude) {
            continue;
        }
        if ($service === null || in_array($service, (array) ($p['options']['service'] ?? []), true)) {
            $list[] = $p;
        }
    }
    return array_slice($list, 0, $limit);
}
