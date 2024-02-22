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
App::get()->config()->set('LOGGER', 'debug', 'loggers', 'app', 'log_level');
App::get()->config()->set('LOGGER', 'debug', 'loggers', 'core', 'log_level');

/*
 * --------------------------------------------------------------------
 * init scripts for wordpress
 * --------------------------------------------------------------------
 */
WordPressCustomize::addCustomPostType(\App\Model\ExampleModel::class);
WordPressCustomize::addCustomPostType(\App\Model\LogModel::class);
WordPressCustomize::disableRedirectCanonical();