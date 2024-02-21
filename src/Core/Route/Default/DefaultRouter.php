<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Route\Default;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Library\HttpStatus;
use Mvc4Wp\Core\Route\RouteHandler;
use Mvc4Wp\Core\Route\RouterInterface;
use Mvc4Wp\Core\Route\RouterTrait;

class DefaultRouter implements RouterInterface
{
    use Castable, RouterTrait;

    public function dispatch(ConfiguratorInterface $config, string $request_method, string $request_uri): RouteHandler
    {
        $routes = $this->routes;
        $dispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $r) use ($config, $routes) {
            foreach ($routes as $key => $value) {
                $keys = explode(self::STATUS_DELIMITER, $key);
                $httpMethod = $keys[0];
                $uris = explode(self::ROUTE_DELIMITER, $keys[1]);
                foreach ($uris as $uri) {
                    $r->addRoute($httpMethod, $uri, $config->get('CONTROLLER_NAMESPACE') . '\\' . $value);
                }
            }
        });
        $routeInfo = $dispatcher->dispatch(strtoupper($request_method), $request_uri);
        return match ($routeInfo[0]) {
            Dispatcher::NOT_FOUND => new RouteHandler(HttpStatus::NOT_FOUND),
            Dispatcher::METHOD_NOT_ALLOWED => new RouteHandler(HttpStatus::METHOD_NOT_ALLOWED),
            Dispatcher::FOUND => new RouteHandler(HttpStatus::OK, $routeInfo[1], $routeInfo[2]),
        };
    }
}