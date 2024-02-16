<?php declare(strict_types=1);

define('__WPMVC_ROOT__', __DIR__);
require_once __WPMVC_ROOT__ . '/vendor/autoload.php';

$wpmvc_app = new System\Application\Application();

/*
 * --------------------------------------------------------------------
 * Configure application(comment out & edit default value for required)
 * --------------------------------------------------------------------
 */
// $wpmvc_app->add(System\Config\CONFIG::DEBUG, 'false');
// $wpmvc_app->add(System\Config\CONFIG::BOOTSTRAP, __WPMVC_ROOT__ . '/src/App/bootstrap.php');
// $wpmvc_app->add(System\Config\CONFIG::CONTROLLER_NAMESPACE, 'App\Controllers');
// $wpmvc_app->add(System\Config\CONFIG::VIEW_DIRECTORY, __WPMVC_ROOT__ . '/src/App/Views/');

/*
 * --------------------------------------------------------------------
 * execute bootstrap
 * --------------------------------------------------------------------
 */
include_once($wpmvc_app->config()->get(System\Config\CONFIG::BOOTSTRAP));