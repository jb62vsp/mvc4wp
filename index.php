<?php declare(strict_types=1);

use Mvc4Wp\System\Service\App;

/*
 * --------------------------------------------------------------------
 * Route Definitions(add route)
 * any => {parameter_name}(same {parameter_name:[^/]+})
 * number => {parameter_name:\d+}
 * --------------------------------------------------------------------
 */
// controller sample
App::get()->router()->get('/', 'HomeController::index');
App::get()->router()->get('/index|/home|/home/|/home/index', 'HomeController::index');
App::get()->router()->get('/home/other/{id:\d+}', 'HomeController::other');
App::get()->router()->get('/home/redirect', 'HomeController::redirect');
// json response sample
App::get()->router()->get('/api|/api/', 'ApiController::index');
App::get()->router()->post('/api|/api/', 'ApiController::post');
// post sample
App::get()->router()->get('/post|/post/|/post/index', 'PostController::index');
App::get()->router()->get('/post/list', 'PostController::list');
App::get()->router()->get('/post/list/{sort}', 'PostController::list');
App::get()->router()->get('/post/list/{sort}/{order}', 'PostController::list');
App::get()->router()->get('/post/{id:\d+}', 'PostController::single');
App::get()->router()->post('/post/', 'PostController::register');
App::get()->router()->put('/post/{id:\d+}', 'PostController::update');
App::get()->router()->delete('/post/{id:\d+}', 'PostController::delete');
// custom example
App::get()->router()->get('/example|/example/|/example/index', 'ExampleController::index');
App::get()->router()->get('/example/list', 'ExampleController::list');
App::get()->router()->get('/example/list/{sort}', 'ExampleController::list');
App::get()->router()->get('/example/list/{sort}/{order}', 'ExampleController::list');
App::get()->router()->get('/example/list/{sort}/{order}/{page:\d+}', 'ExampleController::list');
App::get()->router()->get('/example/list/{sort}/{order}/{page:\d+}/{per_page:\d+}', 'ExampleController::list');
App::get()->router()->get('/example/search', 'ExampleController::list');
App::get()->router()->post('/example/search', 'ExampleController::search');
App::get()->router()->get('/example/{id:\d+}|/example/{id:\d+}/', 'ExampleController::single');
App::get()->router()->post('/example/', 'ExampleController::register');
App::get()->router()->put('/example/{id:\d+}|/example/{id:\d+}/', 'ExampleController::update');
App::get()->router()->delete('/example/{id:\d+}|/example/{id:\d+}/', 'ExampleController::delete');

/*
 * --------------------------------------------------------------------
 * init scripts for application
 * --------------------------------------------------------------------
 */
\Mvc4Wp\System\Service\Logging::configure(App::get()->config());

/*
 * --------------------------------------------------------------------
 * Run application
 * --------------------------------------------------------------------
 */
App::get()->run();