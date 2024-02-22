<?php declare(strict_types=1);

use App\Model\ExampleModel;
use App\Model\LogModel;
use Mvc4Wp\Core\Library\WordPressCustomize;
use Mvc4Wp\Core\Service\App;

define('__MVC4WP_ROOT__', __DIR__);
require_once(__MVC4WP_ROOT__ . '/vendor/autoload.php');

App::get()->config()->set('LOGGER', 'debug', 'loggers', 'app', 'log_level');
App::get()->config()->set('LOGGER', 'debug', 'loggers', 'core', 'log_level');

WordPressCustomize::addCustomPostType(ExampleModel::class);
WordPressCustomize::addCustomPostType(LogModel::class);