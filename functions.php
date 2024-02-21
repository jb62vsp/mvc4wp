<?php declare(strict_types=1);

define('__MVC4WP_ROOT__', __DIR__);
require_once(__MVC4WP_ROOT__ . '/vendor/autoload.php');

use Mvc4Wp\Core\Library\WordPressCustomize;
use Mvc4Wp\Core\Service\App;
use Mvc4Wp\Core\Service\Logging;

/*
 * --------------------------------------------------------------------
 * Configure application(comment out OR edit value for required)
 * --------------------------------------------------------------------
 */
App::get()->config()->add('LOGGER', [
    'default_logger_name' => 'app',
    'loggers' => [
        'app' => [
            'logger_factory' => '\Mvc4Wp\Core\Logger\Default\DefaultFileLoggerFactory',
            'directory' => __MVC4WP_ROOT__ . '/log/',
            'basefilename' => 'app',
            'file_date_format' => 'Ymd',
            'datetime_format' => 'Y-m-d H:i:s',
            'timezone' => 'Asia/Tokyo',
            'log_level' => 'debug',
        ],
        'system' => [
            'logger_factory' => '\Mvc4Wp\Core\Logger\Default\DefaultFileLoggerFactory',
            'directory' => __MVC4WP_ROOT__ . '/log/',
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
WordPressCustomize::addCustomPostType(\App\Model\ExampleModel::class);
WordPressCustomize::addCustomPostType(\App\Model\LogModel::class);
WordPressCustomize::disableRedirectCanonical();