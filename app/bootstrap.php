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
define('CONTENT_DIR', ROOT_DIR . '/content');
define('RUNTIME_DIR', CONTENT_DIR . '/.runtime');
if (!defined('PUBLIC_DIR')) {
    define('PUBLIC_DIR', is_dir(ROOT_DIR . '/public') ? ROOT_DIR . '/public' : ROOT_DIR);
}

/*
 * Git deploy (Hostinger): the deploy branch ships the initial content in _seed/ instead of content/.
 * It is copied only when the target is missing, so a redeploy never overwrites edits made in the admin.
 */
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
seed_dir(ROOT_DIR . '/_seed/content', ROOT_DIR . '/content');
seed_dir(ROOT_DIR . '/_seed/vzorkovniky', PUBLIC_DIR . '/downloads/vzorkovniky');

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
