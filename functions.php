<?php declare(strict_types=1);

define('__WPMVC_ROOT__', __DIR__);
require_once __WPMVC_ROOT__ . '/vendor/autoload.php';

$wpmvc_app = new System\Application\Application();

/*
 * --------------------------------------------------------------------
 * Configure application(comment out & edit default value for required)
 * --------------------------------------------------------------------
 */
// $wpmvc_app->addConfig(CONFIG::DEBUG, 'false');
// $wpmvc_app->addConfig(CONFIG::BOOTSTRAP, __WPMVC_ROOT__ . '/src/App/bootstrap.php');
// $wpmvc_app->addConfig(CONFIG::CONTROLLER_NAMESPACE, 'App\Controllers');
// $wpmvc_app->addConfig(CONFIG::VIEW_DIRECTORY, __WPMVC_ROOT__ . '/src/App/Views/');

require_once $wpmvc_app->getConfig(System\Config\CONFIG::BOOTSTRAP);