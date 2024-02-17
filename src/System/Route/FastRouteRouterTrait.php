<?php declare(strict_types=1);
namespace System\Route;

use FastRoute;
use FastRoute\RouteCollector;
use System\Config\CONFIG;
use System\Config\ConfigInterface;
use System\Core\HttpStatus;

/**
 * DefaultRouter has FastRoute that inner behavior.
 * 
 * @see https://github.com/nikic/FastRoute
 */
trait FastRouteRouterTrait
{
    public function dispatch(ConfigInterface $config, string $request_method, string $request_uri): RouteHandler
    {
        $routes = $this->routes;
        $dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) use ($config, $routes) {
            foreach ($routes as $key => $value) {
                $keys = explode(RouterInterface::STATUS_DELIMITER, $key);
                $httpMethod = $keys[0];
                $uris = explode(RouterInterface::ROUTE_DELIMITER, $keys[1]);
                foreach ($uris as $uri) {
                    $r->addRoute($httpMethod, $uri, $config->get(CONFIG::CONTROLLER_NAMESPACE) . '\\' . $value);
                }
            }
        });
        $routeInfo = $dispatcher->dispatch(strtoupper($request_method), $request_uri);
        return match ($routeInfo[0]) {
            FastRoute\Dispatcher::NOT_FOUND => new RouteHandler(HttpStatus::NOT_FOUND),
            FastRoute\Dispatcher::METHOD_NOT_ALLOWED => new RouteHandler(HttpStatus::METHOD_NOT_ALLOWED),
            FastRoute\Dispatcher::FOUND => new RouteHandler(HttpStatus::OK, $routeInfo[1], $routeInfo[2]),
        };
    }
}