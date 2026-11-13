<?php
/*
 * Century 2000 – application bootstrap.
 *
 * Layout:  app/       code and templates (not web-accessible)
 *          content/   JSON content edited in the admin, backups, runtime files
 *          public/    web root (index.php, admin/, assets/, uploads/)
 */
declare(strict_types=1);

define('ROOT_DIR', dirname(__DIR__));
define('APP_DIR', __DIR__);
/*
 * Hosting build (Hostinger Git deploy, see tools/build-hostinger.sh): every deploy replaces the whole
 * public_html, so everything the client changes (content, uploaded photos, PDF catalogues, config.php)
 * lives in web-data/ next to public_html. Locally and on other hosts DATA_DIR is the project root.
 */
define('HOSTING_BUILD', is_dir(ROOT_DIR . '/_seed'));
define('DATA_DIR', HOSTING_BUILD ? dirname(ROOT_DIR) . '/web-data' : ROOT_DIR);
define('CONTENT_DIR', DATA_DIR . '/content');
define('RUNTIME_DIR', CONTENT_DIR . '/.runtime');
if (!defined('PUBLIC_DIR')) {
    define('PUBLIC_DIR', is_dir(ROOT_DIR . '/public') ? ROOT_DIR . '/public' : ROOT_DIR);
}

/* Copies the initial content shipped in _seed/ – only when the target is missing, never over client edits. */
function seed_dir(string $from, string $to): void
{
    if (is_dir($to) || !is_dir($from)) {
        return;
    }
    $tmp = $to . '.seed-' . bin2hex(random_bytes(4));
    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($from, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    @mkdir($tmp, 0755, true);
    foreach ($items as $item) {
        $dest = $tmp . '/' . substr($item->getPathname(), strlen($from) + 1);
        $item->isDir() ? @mkdir($dest, 0755, true) : @copy($item->getPathname(), $dest);
    }
    if (!@rename($tmp, $to)) {
        // another request was faster – keep its copy
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($tmp, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $item) {
            $item->isDir() ? @rmdir($item->getPathname()) : @unlink($item->getPathname());
        }
        @rmdir($tmp);
    }
}
if (HOSTING_BUILD) {
    seed_dir(ROOT_DIR . '/_seed/content', CONTENT_DIR);
    seed_dir(ROOT_DIR . '/_seed/uploads', DATA_DIR . '/uploads');
    seed_dir(ROOT_DIR . '/_seed/vzorkovniky', DATA_DIR . '/vzorkovniky');
    if (!is_file(CONTENT_DIR . '/global.json')) {
        // web-data/ could not be created – say so instead of failing somewhere later
        http_response_code(503);
        header('Content-Type: text/plain; charset=utf-8');
        error_log('Century 2000: cannot write ' . DATA_DIR);
        exit("Web se připravuje. (Nelze zapsat do složky web-data vedle public_html.)\n");
    }
    // Photos and PDFs are served by PHP from web-data (handle_request); where the host allows symlinks,
    // a link lets the web server serve them directly. Every deploy removes the links, so recreate them.
    if (function_exists('symlink')) {
        foreach (['/uploads' => '/uploads', '/vzorkovniky' => '/downloads/vzorkovniky'] as $data => $web) {
            if (!is_link(PUBLIC_DIR . $web) && !file_exists(PUBLIC_DIR . $web)) {
                @symlink(DATA_DIR . $data, PUBLIC_DIR . $web);
            }
        }
    }
}

mb_internal_encoding('UTF-8');
// Errors go to the log, never to the page (paths and code would leak). The built-in dev server shows them.
if (PHP_SAPI !== 'cli-server' && PHP_SAPI !== 'cli') {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
}
ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
date_default_timezone_set('Europe/Prague');

require APP_DIR . '/lib/helpers.php';
require APP_DIR . '/lib/content.php';
require APP_DIR . '/lib/render.php';
require APP_DIR . '/lib/seo.php';
require APP_DIR . '/lib/tracking.php';
require APP_DIR . '/lib/mailer.php';
require APP_DIR . '/lib/forms.php';
require APP_DIR . '/lib/redirects.php';

$GLOBALS['config'] = load_config();
