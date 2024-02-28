<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Route\Default;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Library\HttpStatus;
use Mvc4Wp\Core\Route\RouteHandler;
use Mvc4Wp\Core\Route\RouterInterface;
use Mvc4Wp\Core\Route\Routerable;

class DefaultRouter implements RouterInterface
{
    use Castable, Routerable;

    public function dispatch(ConfiguratorInterface $config, string $request_method, string $request_uri): RouteHandler
    {
        $routes = $this->routes;
        $dispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $r) use ($config, $routes) {
            foreach ($routes as $key => $value) {
                $keys = explode(self::STATUS_DELIMITER, $key);
                $httpMethod = $keys[0];
                $uris = explode(self::ROUTE_DELIMITER, $keys[1]);
                foreach ($uris as $uri) {
                    $r->addRoute($httpMethod, $uri, $config->get('controller_namespace') . '\\' . $value);
                }
            }
        });

        $routeInfo = $dispatcher->dispatch(strtoupper($request_method), $request_uri);

        $result = match ($routeInfo[0]) {
            Dispatcher::NOT_FOUND => new RouteHandler(HttpStatus::NOT_FOUND),
            Dispatcher::METHOD_NOT_ALLOWED => new RouteHandler(HttpStatus::METHOD_NOT_ALLOWED),
            Dispatcher::FOUND => new RouteHandler(HttpStatus::OK, $routeInfo[1], $routeInfo[2]),
        };

        debug_add('route', [
            'routes' => $this->routes,
            'method' => $request_method,
            'uri' => $request_uri,
            'info' => $routeInfo,
            'route' => $result,
        ]);

        return $result;
    }
}