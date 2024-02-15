<?php declare(strict_types=1);

define('__WPMVC_ROOT__', __DIR__);
require_once __WPMVC_ROOT__ . '/vendor/autoload.php';

$wpmvc_app = new System\Application\Application();

/*
 * --------------------------------------------------------------------
 * Configure application(comment out & edit default value for required)
 * --------------------------------------------------------------------
 */


/*
 * --------------------------------------------------------------------
 * execute bootstrap
 * --------------------------------------------------------------------
 */
require_once $wpmvc_app->getConfig(System\Config\CONFIG::BOOTSTRAP);