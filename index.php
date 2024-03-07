<?php declare(strict_types=1);

use App\Controller\ApiController;
use App\Controller\ExampleController;
use App\Controller\HomeController;
use App\Controller\LoginController;
use App\Controller\PostController;
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
App::get()->router()->GET('/login|/login/', [LoginController::class]);
App::get()->router()->POST('/login|/login/', [LoginController::class, 'login']);
App::get()->router()->GET('/logout|/logout{params:.*}', [LoginController::class, 'logout']);
// controller sample
App::get()->router()->GET('/', [HomeController::class]);
App::get()->router()->GET('/index|/home|/home/|/home/index', [HomeController::class]);
App::get()->router()->GET('/home/other/{id:\d+}', [HomeController::class, 'other']);
App::get()->router()->GET('/home/redirect', [HomeController::class, 'redirect']);
// json response sample
App::get()->router()->GET('/api|/api/', [ApiController::class]);
App::get()->router()->POST('/api|/api/', [ApiController::class, 'post']);
// post sample
App::get()->router()->GET('/post|/post/|/post/index', [PostController::class]);
App::get()->router()->GET('/post/list', [PostController::class, 'list']);
App::get()->router()->GET('/post/list/{sort}', [PostController::class, 'list']);
App::get()->router()->GET('/post/list/{sort}/{order}', [PostController::class, 'list']);
App::get()->router()->GET('/post/{id:\d+}', [PostController::class, 'single']);
App::get()->router()->POST('/post/', [PostController::class, 'register']);
App::get()->router()->PUT('/post/{id:\d+}', [PostController::class, 'update']);
App::get()->router()->DELETE('/post/{id:\d+}', [PostController::class, 'delete']);
// custom example
App::get()->router()->GET('/example|/example/|/example/index', [ExampleController::class]);
App::get()->router()->GET('/example/list', [ExampleController::class, 'list']);
App::get()->router()->GET('/example/list/{sort}', [ExampleController::class, 'list']);
App::get()->router()->GET('/example/list/{sort}/{order}', [ExampleController::class, 'list']);
App::get()->router()->GET('/example/list/{sort}/{order}/{page:\d+}', [ExampleController::class, 'list']);
App::get()->router()->GET('/example/list/{sort}/{order}/{page:\d+}/{per_page:\d+}', [ExampleController::class, 'list']);
App::get()->router()->GET('/example/search', [ExampleController::class, 'list']);
App::get()->router()->POST('/example/search', [ExampleController::class, 'search']);
App::get()->router()->GET('/example/{id:\d+}', [ExampleController::class, 'single']);
App::get()->router()->POST('/example/', [ExampleController::class, 'register']);
App::get()->router()->PUT('/example/{id:\d+}', [ExampleController::class, 'update']);
App::get()->router()->DELETE('/example/{id:\d+}', [ExampleController::class, 'delete']);

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