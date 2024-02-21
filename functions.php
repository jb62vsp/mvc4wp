<?php declare(strict_types=1);

define('__MVC4WP_ROOT__', __DIR__);
require_once(__MVC4WP_ROOT__ . '/vendor/autoload.php');

use Mvc4Wp\Core\Service\App;
use Mvc4Wp\Core\Service\Logging;
use Mvc4Wp\Core\Service\WpCustomize;

/*
 * --------------------------------------------------------------------
 * Configure application(comment out OR edit value for required)
 * --------------------------------------------------------------------
 */
App::get()->config()->add('LOGGER', [
    'default_logger_name' => 'app',
    'loggers' => [
        'app' => [
            'logger_factory' => '\Mvc4Wp\Core\Logger\FileLoggerFactory',
            'directory' => __WPMVC_ROOT__ . '/log/',
            'basefilename' => 'app',
            'file_date_format' => 'Ymd',
            'datetime_format' => 'Y-m-d H:i:s',
            'timezone' => 'Asia/Tokyo',
            'log_level' => 'debug',
        ],
        'system' => [
            'logger_factory' => '\Mvc4Wp\Core\Logger\FileLoggerFactory',
            'directory' => __WPMVC_ROOT__ . '/log/',
            'basefilename' => 'sys',
            'file_date_format' => 'Ymd',
            'datetime_format' => 'Y-m-d H:i:s',
            'timezone' => 'Asia/Tokyo',
            'log_level' => 'debug',
        ],
        'model' => [
            'logger_factory' => '\App\Logger\LogModelLoggerFactory',
            'log_level' => 'info',
        ],
    ],
]);
Logging::configure(App::get()->config());

/*
 * --------------------------------------------------------------------
 * init scripts for wordpress
 * --------------------------------------------------------------------
 */
WpCustomize::addCustomPostType(\App\Model\ExampleModel::class);
WpCustomize::addCustomPostType(\App\Model\LogModel::class);
WpCustomize::disableRedirectCanonical();