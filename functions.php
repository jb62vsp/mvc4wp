<?php declare(strict_types=1);

define('__WPMVC_ROOT__', __DIR__);
require_once(__WPMVC_ROOT__ . '/vendor/autoload.php');

global $wpmvc_app;
$wpmvc_app = new \System\Application\Application();

/*
 * --------------------------------------------------------------------
 * Configure application(comment out & edit default value for required)
 * --------------------------------------------------------------------
 */
// $wpmvc_app->config()->add(\System\Config\CONFIG::DEBUG, 'false');
// $wpmvc_app->config()->add(\System\Config\CONFIG::LOGGER, 'System\Logger\FileLogger');
// $wpmvc_app->config()->add(\System\Config\CONFIG::LOG_DIRECTORY, __WPMVC_ROOT__ . '/log/');
// $wpmvc_app->config()->add(\System\Config\CONFIG::LOG_FILENAME, 'application');
// $wpmvc_app->config()->add(\System\Config\CONFIG::LOG_DATE_FORMAT, 'Ymd');
// $wpmvc_app->config()->add(\System\Config\CONFIG::CONTROLLER_NAMESPACE, 'App\Controllers');
// $wpmvc_app->config()->add(\System\Config\CONFIG::VIEW_DIRECTORY, __WPMVC_ROOT__ . '/src/App/Views/');

/*
 * --------------------------------------------------------------------
 * init scripts for wordpress
 * --------------------------------------------------------------------
 */
\System\Service\WpCustomize::addCustomPostType(\App\Models\ExampleModel::class);
\System\Service\WpCustomize::disableRedirectCanonical();