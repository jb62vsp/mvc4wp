<?php declare(strict_types=1);

use App\Model\ExampleEntity;
use App\Model\LogEntity;
use Mvc4Wp\Core\Library\WordPressCustomize;
use Mvc4Wp\Core\Service\App;
use Mvc4Wp\Core\Service\Logging;

define('__MVC4WP_ROOT__', __DIR__);
require_once(__MVC4WP_ROOT__ . '/vendor/autoload.php');

App::get()->config()->set('logger.loggers.app.log_level', 'debug');
App::get()->config()->set('logger.loggers.core.log_level', 'debug');

Logging::configure(App::get()->config());

WordPressCustomize::addCustomPostType(ExampleEntity::class);
WordPressCustomize::addCustomPostType(LogEntity::class);