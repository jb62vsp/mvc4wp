<?php declare(strict_types=1);

define('__MVC4WP_ROOT__', __DIR__);
require_once(__MVC4WP_ROOT__ . '/vendor/autoload.php');

use App\Logger\LogModelLoggerFactory;
use App\Model\ExampleModel;
use App\Model\LogModel;
use Mvc4Wp\Core\Library\WordPressCustomize;
use Mvc4Wp\Core\Service\App;

/*
 * --------------------------------------------------------------------
 * Configure application(comment out OR edit value for required)
 * --------------------------------------------------------------------
 */
App::get()->config()->set('LOGGER', 'debug', 'loggers', 'app', 'log_level');
App::get()->config()->set('LOGGER', 'debug', 'loggers', 'core', 'log_level');
App::get()->config()->set('LOGGER', [
    'logger_factory' => LogModelLoggerFactory::class,
    'log_level' => 'info',
], 'loggers', 'model');

/*
 * --------------------------------------------------------------------
 * init scripts for wordpress
 * --------------------------------------------------------------------
 */
WordPressCustomize::addCustomPostType(ExampleModel::class);
WordPressCustomize::addCustomPostType(LogModel::class);
WordPressCustomize::disableRedirectCanonical();