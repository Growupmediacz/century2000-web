<?php
/* Century 2000 – administration entry point (/admin/). */
declare(strict_types=1);

define('PUBLIC_DIR', dirname(__DIR__));
require is_dir(PUBLIC_DIR . '/../app') ? PUBLIC_DIR . '/../app/bootstrap.php' : PUBLIC_DIR . '/app/bootstrap.php';
require APP_DIR . '/admin/admin.php';

admin_handle();
