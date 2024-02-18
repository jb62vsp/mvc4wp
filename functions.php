<?php declare(strict_types=1);

define('__WPMVC_ROOT__', __DIR__);
require_once(__WPMVC_ROOT__ . '/vendor/autoload.php');

global $wpmvc_app;
$wpmvc_app = (new \System\Application\DefaultApplicationFactory())->create();