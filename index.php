<?php declare(strict_types=1);

use Mvc4Wp\System\Config\CONFIG;
use Mvc4Wp\System\Service\App;
use Mvc4Wp\System\Service\Logging;

App::get()->config()->set(CONFIG::LOGGER, 'debug', 'loggers', 'system', 'log_level');
Logging::configure(App::get()->config());

// App::get()->router()->get('/{params:.*}', 'HomeController::index');
App::get()->router()->get('/hello/', 'HomeController::index');

App::get()->run();