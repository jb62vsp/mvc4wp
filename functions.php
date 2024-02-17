<?php declare(strict_types=1);

define('__WPMVC_ROOT__', __DIR__);
require_once(__WPMVC_ROOT__ . '/vendor/autoload.php');

global $wpmvc_app;
$wpmvc_app = new \System\Application\Application();

/*
 * --------------------------------------------------------------------
 * Configure application(comment out OR edit value for required)
 * --------------------------------------------------------------------
 */
$wpmvc_app->config()->add(\System\Config\CONFIG::DEBUG, 'false');
$wpmvc_app->config()->add(\System\Config\CONFIG::LOGGER, [
    'default_logger_name' => 'app',
    'loggers' => [
        'app' => [
            'logger_factory' => '\System\Logger\FileLoggerFactory',
            'directory' => __WPMVC_ROOT__ . '/log/',
            'basefilename' => 'app',
            'date_format' => 'Ymd',
            'log_level' => 'notice',
        ],
        'system' => [
            'logger_factory' => '\System\Logger\FileLoggerFactory',
            'directory' => __WPMVC_ROOT__ . '/log/',
            'basefilename' => 'sys',
            'date_format' => 'Ymd',
            'log_level' => 'notice',
        ],
        'model' => [
            'logger_factory' => '\App\Logger\LogModelLoggerFactory',
            'log_level' => 'info',
        ],
    ],
]);
$wpmvc_app->config()->add(\System\Config\CONFIG::CONTROLLER_NAMESPACE, 'App\Controllers');
$wpmvc_app->config()->add(\System\Config\CONFIG::VIEW_DIRECTORY, __WPMVC_ROOT__ . '/src/App/Views/');

/*
 * --------------------------------------------------------------------
 * init scripts for wordpress
 * --------------------------------------------------------------------
 */
\System\Service\WpCustomize::addCustomPostType(\App\Models\ExampleModel::class);
\System\Service\WpCustomize::addCustomPostType(\App\Models\LogModel::class);
\System\Service\WpCustomize::disableRedirectCanonical();