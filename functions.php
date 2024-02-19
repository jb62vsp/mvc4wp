<?php declare(strict_types=1);

define('__WPMVC_ROOT__', __DIR__);
require_once(__WPMVC_ROOT__ . '/vendor/autoload.php');

/*
 * --------------------------------------------------------------------
 * Configure application(comment out OR edit value for required)
 * --------------------------------------------------------------------
 */
\Mvc4Wp\System\Service\App::get()->config()->add('LOGGER', [
    'default_logger_name' => 'app',
    'loggers' => [
        'app' => [
            'logger_factory' => '\Mvc4Wp\System\Logger\FileLoggerFactory',
            'directory' => __WPMVC_ROOT__ . '/log/',
            'basefilename' => 'app',
            'date_format' => 'Ymd',
            'log_level' => 'debug',
        ],
        'system' => [
            'logger_factory' => '\Mvc4Wp\System\Logger\FileLoggerFactory',
            'directory' => __WPMVC_ROOT__ . '/log/',
            'basefilename' => 'sys',
            'date_format' => 'Ymd',
            'log_level' => 'debug',
        ],
        'model' => [
            'logger_factory' => '\App\Logger\LogModelLoggerFactory',
            'log_level' => 'info',
        ],
    ],
]);

/*
 * --------------------------------------------------------------------
 * init scripts for wordpress
 * --------------------------------------------------------------------
 */
\Mvc4Wp\System\Service\WpCustomize::addCustomPostType(\App\Model\ExampleModel::class);
\Mvc4Wp\System\Service\WpCustomize::addCustomPostType(\App\Model\LogModel::class);
\Mvc4Wp\System\Service\WpCustomize::disableRedirectCanonical();