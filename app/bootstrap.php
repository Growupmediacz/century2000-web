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
