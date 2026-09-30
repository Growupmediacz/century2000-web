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
date_default_timezone_set('Europe/Prague');

require APP_DIR . '/lib/helpers.php';
require APP_DIR . '/lib/content.php';
require APP_DIR . '/lib/render.php';
require APP_DIR . '/lib/seo.php';
require APP_DIR . '/lib/mailer.php';
require APP_DIR . '/lib/forms.php';

$GLOBALS['config'] = load_config();
