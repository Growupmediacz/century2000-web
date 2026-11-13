<?php
/* Century 2000 – front controller. All requests that are not files end up here (see .htaccess). */
declare(strict_types=1);

// PHP built-in dev server: serve existing files directly.
if (PHP_SAPI === 'cli-server') {
    $file = realpath(__DIR__ . rawurldecode((string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    if ($file !== false && !str_starts_with($file, __DIR__)) {
        $file = false;
    }
    if ($file !== false && is_file($file) && $file !== __FILE__) {
        return false;
    }
    if ($file !== false && is_dir($file) && is_file($file . '/index.html')) {
        header('Content-Type: text/html; charset=utf-8');   // static export (tools/export-static.php)
        readfile($file . '/index.html');
        return true;
    }
    if ($file !== false && $file !== __DIR__ && is_file($file . '/index.php')) {
        require $file . '/index.php';   // e.g. /admin/
        return true;
    }
}

define('PUBLIC_DIR', __DIR__);
// app/ lives next to public/ (recommended) or inside the web root on hosts without that option.
require is_dir(__DIR__ . '/../app') ? __DIR__ . '/../app/bootstrap.php' : __DIR__ . '/app/bootstrap.php';

handle_request();
