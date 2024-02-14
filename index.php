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
$app->get('/home', 'HomeController::index');
$app->get('/home/index', 'HomeController::index');
$app->get('/home/other/{id:\d+}', 'HomeController::other');
$app->get('/home/redirect', 'HomeController::redirect');
$app->post('/home', 'HomeController::register');
$app->put('/home/{id:\d+}', 'HomeController::update');
$app->delete('/home/{id:\d+}', 'HomeController::delete');
$app->get('/ajax', 'AjaxController::index');

/*
 * --------------------------------------------------------------------
 * Run application
 * --------------------------------------------------------------------
 */
$app->run();