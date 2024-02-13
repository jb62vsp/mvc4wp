<?php declare(strict_types=1);

define('__WPMVC_ROOT__', __DIR__);

require_once __WPMVC_ROOT__ . '/vendor/autoload.php';

$app = new System\Application\Application();

/*
 * --------------------------------------------------------------------
 * Configure application(comment out & edit default value for required)
 * --------------------------------------------------------------------
 */
// $app->addConfig(System\Config\CONFIG::DEBUG, 'false');
// $app->addConfig(System\Config\CONFIG::MODEL_NAMESPACE, 'App\Models');
// $app->addConfig(System\Config\CONFIG::CONTROLLER_NAMESPACE, 'App\Controllers');
// $app->addConfig(System\Config\CONFIG::VIEW_DIRECTORY, __WPMVC_ROOT__ . '/src/App/Views/');
// $app->addConfig(System\Config\CONFIG::PUBLIC_DIRECTORY, __WPMVC_ROOT__ . '/public');

/*
 * --------------------------------------------------------------------
 * Route Definitions(add route)
 * any => {parameter_name}(same {parameter_name:[^/]+})
 * number => {parameter_name:\d+}
 * --------------------------------------------------------------------
 */
// sample
// $app->get('/', 'HomeController::index');
// $app->get('/home', 'HomeController::index');
// $app->get('/home/index', 'HomeController::index');
// $app->get('/home/other/{id:\d+}', 'HomeController::other');
// $app->get('/home/redirect', 'HomeController::redirect');
// $app->post('/home', 'HomeController::register');
// $app->put('/home/{id:\d+}', 'HomeController::update');
// $app->delete('/home/{id:\d+}', 'HomeController::delete');


/*
 * --------------------------------------------------------------------
 * Run application
 * --------------------------------------------------------------------
 */
$app->run();