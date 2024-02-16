<?php declare(strict_types=1);

/*
 * --------------------------------------------------------------------
 * Route Definitions(add route)
 * any => {parameter_name}(same {parameter_name:[^/]+})
 * number => {parameter_name:\d+}
 * --------------------------------------------------------------------
 */
// controller sample
$wpmvc_app->router()->get('/', 'HomeController::index');
$wpmvc_app->router()->get('/home/', 'HomeController::index');
$wpmvc_app->router()->get('/home/index', 'HomeController::index');
$wpmvc_app->router()->get('/home/other/{id:\d+}', 'HomeController::other');
$wpmvc_app->router()->get('/home/redirect', 'HomeController::redirect');
// json response sample
$wpmvc_app->router()->get('/ajax/', 'AjaxController::index');
$wpmvc_app->router()->get('/ajax/index', 'AjaxController::index');
// post sample
$wpmvc_app->router()->get('/post/', 'PostController::index');
$wpmvc_app->router()->get('/post/index', 'PostController::index');
$wpmvc_app->router()->get('/post/list', 'PostController::list');
$wpmvc_app->router()->get('/post/list/{sort}', 'PostController::list');
$wpmvc_app->router()->get('/post/list/{sort}/{order}', 'PostController::list');
$wpmvc_app->router()->get('/post/{id:\d+}', 'PostController::single');
$wpmvc_app->router()->post('/post/', 'PostController::register');
$wpmvc_app->router()->put('/post/{id:\d+}', 'PostController::update');
$wpmvc_app->router()->delete('/post/{id:\d+}', 'PostController::delete');
// custom example
$wpmvc_app->router()->get('/example/', 'ExampleController::index');
$wpmvc_app->router()->get('/example/index', 'ExampleController::index');
$wpmvc_app->router()->get('/example/list', 'ExampleController::list');
$wpmvc_app->router()->get('/example/list/{sort}', 'ExampleController::list');
$wpmvc_app->router()->get('/example/list/{sort}/{order}', 'ExampleController::list');
$wpmvc_app->router()->get('/example/search', 'ExampleController::list');
$wpmvc_app->router()->post('/example/search', 'ExampleController::search');
$wpmvc_app->router()->get('/example/{id:\d+}', 'ExampleController::single');
$wpmvc_app->router()->post('/example/', 'ExampleController::register');
$wpmvc_app->router()->put('/example/{id:\d+}', 'ExampleController::update');
$wpmvc_app->router()->delete('/example/{id:\d+}', 'ExampleController::delete');

/*
 * --------------------------------------------------------------------
 * Run application
 * --------------------------------------------------------------------
 */
$wpmvc_app->run();