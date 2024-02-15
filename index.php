<?php declare(strict_types=1);

/*
 * --------------------------------------------------------------------
 * Route Definitions(add route)
 * any => {parameter_name}(same {parameter_name:[^/]+})
 * number => {parameter_name:\d+}
 * --------------------------------------------------------------------
 */
// controller sample
$wpmvc_app->get('/', 'HomeController::index');
$wpmvc_app->get('/home/', 'HomeController::index');
$wpmvc_app->get('/home/index', 'HomeController::index');
$wpmvc_app->get('/home/other/{id:\d+}', 'HomeController::other');
$wpmvc_app->get('/home/redirect', 'HomeController::redirect');
// json response sample
$wpmvc_app->get('/ajax/', 'AjaxController::index');
$wpmvc_app->get('/ajax/index', 'AjaxController::index');
// post sample
$wpmvc_app->get('/post/', 'PostController::index');
$wpmvc_app->get('/post/index', 'PostController::index');
$wpmvc_app->get('/post/list', 'PostController::list');
$wpmvc_app->get('/post/list/{sort}', 'PostController::list');
$wpmvc_app->get('/post/list/{sort}/{order}', 'PostController::list');
$wpmvc_app->get('/post/{id:\d+}', 'PostController::single');
$wpmvc_app->post('/post/', 'PostController::register');
$wpmvc_app->put('/post/{id:\d+}', 'PostController::update');
$wpmvc_app->delete('/post/{id:\d+}', 'PostController::delete');

/*
 * --------------------------------------------------------------------
 * Run application
 * --------------------------------------------------------------------
 */
$wpmvc_app->run();