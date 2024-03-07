<?php declare(strict_types=1);

use Mvc4Wp\Core\Service\App;
use Mvc4Wp\Core\Service\Helper;

/*
 * --------------------------------------------------------------------
 * Route Definitions(add route)
 * any => {parameter_name}(same {parameter_name:[^/]+})
 * number => {parameter_name:\d+}
 * --------------------------------------------------------------------
 */
// login controller sample
App::get()->router()->GET('/login|/login/', 'LoginController::index');
App::get()->router()->POST('/login|/login/', 'LoginController::login');
App::get()->router()->GET('/logout|/logout/', 'LoginController::logout');
// controller sample
App::get()->router()->GET('/', 'HomeController::index');
App::get()->router()->GET('/index|/home|/home/|/home/index', 'HomeController::index');
App::get()->router()->GET('/home/other/{id:\d+}', 'HomeController::other');
App::get()->router()->GET('/home/redirect', 'HomeController::redirect');
// json response sample
App::get()->router()->GET('/api|/api/', 'ApiController::index');
App::get()->router()->POST('/api|/api/', 'ApiController::post');
// post sample
App::get()->router()->GET('/post|/post/|/post/index', 'PostController::index');
App::get()->router()->GET('/post/list', 'PostController::list');
App::get()->router()->GET('/post/list/{sort}', 'PostController::list');
App::get()->router()->GET('/post/list/{sort}/{order}', 'PostController::list');
App::get()->router()->GET('/post/{id:\d+}', 'PostController::single');
App::get()->router()->POST('/post/', 'PostController::register');
App::get()->router()->PUT('/post/{id:\d+}', 'PostController::update');
App::get()->router()->DELETE('/post/{id:\d+}', 'PostController::delete');
// custom example
App::get()->router()->GET('/example|/example/|/example/index', 'ExampleController::index');
App::get()->router()->GET('/example/list', 'ExampleController::list');
App::get()->router()->GET('/example/list/{sort}', 'ExampleController::list');
App::get()->router()->GET('/example/list/{sort}/{order}', 'ExampleController::list');
App::get()->router()->GET('/example/list/{sort}/{order}/{page:\d+}', 'ExampleController::list');
App::get()->router()->GET('/example/list/{sort}/{order}/{page:\d+}/{per_page:\d+}', 'ExampleController::list');
App::get()->router()->GET('/example/search', 'ExampleController::list');
App::get()->router()->POST('/example/search', 'ExampleController::search');
App::get()->router()->GET('/example/{id:\d+}', 'ExampleController::single');
App::get()->router()->POST('/example/', 'ExampleController::register');
App::get()->router()->PUT('/example/{id:\d+}', 'ExampleController::update');
App::get()->router()->DELETE('/example/{id:\d+}', 'ExampleController::delete');

/*
 * --------------------------------------------------------------------
 * Initialize application
 * --------------------------------------------------------------------
 */
Helper::load('View');

 /*
 * --------------------------------------------------------------------
 * Run application
 * --------------------------------------------------------------------
 */
App::get()->run();