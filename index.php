<?php declare(strict_types=1);

$app = new System\Application\Application();

/*
 * --------------------------------------------------------------------
 * Route Definitions(add route)
 * any => {parameter_name}(same {parameter_name:[^/]+})
 * number => {parameter_name:\d+}
 * --------------------------------------------------------------------
 */
// sample
$app->get('/', 'HomeController::index');
$app->get('/home/', 'HomeController::index');
$app->get('/home/index', 'HomeController::index');
$app->get('/home/other/{id:\d+}', 'HomeController::other');
$app->get('/home/redirect', 'HomeController::redirect');

$app->get('/ajax/', 'AjaxController::index');
$app->get('/ajax/index', 'AjaxController::index');

$app->get('/post/', 'PostController::index');
$app->get('/post/index', 'PostController::index');
$app->get('/post/list', 'PostController::list');
$app->get('/post/list/{sort}', 'PostController::list');
$app->get('/post/list/{sort}/{order}', 'PostController::list');
$app->get('/post/{id:\d+}', 'PostController::single');
$app->post('/post/', 'PostController::register');
$app->put('/post/{id:\d+}', 'PostController::update');
$app->delete('/post/{id:\d+}', 'PostController::delete');

/*
 * --------------------------------------------------------------------
 * Run application
 * --------------------------------------------------------------------
 */
$app->run();