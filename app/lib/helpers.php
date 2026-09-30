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
