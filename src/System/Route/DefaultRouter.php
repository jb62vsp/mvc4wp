<?php declare(strict_types=1);
namespace System\Route;

use FastRoute;
use FastRoute\RouteCollector;
use System\Config\CONFIG;
use System\Config\ConfigInterface;
use System\Core\Cast;
use System\Core\HttpStatus;

/**
 * DefaultRouter has FastRoute that inner behavior.
 * 
 * @see https://github.com/nikic/FastRoute
 */
class DefaultRouter implements RouterInterface
{
    use Cast;

    private const STATUS_DELIMITER = '`';

    private const ROUTE_DELIMITER = '|';

    private const GET = 'GET';

    private const POST = 'POST';

    private const PUT = 'PUT';

    private const DELETE = 'DELETE';

    private array $routes = [];

    public function get(string $route, string $handler): void
    {
        $this->addRoute(self::GET, $route, $handler);
    }

    public function post(string $route, string $handler): void
    {
        $this->addRoute(self::POST, $route, $handler);
    }

    public function put(string $route, string $handler): void
    {
        $this->addRoute(self::PUT, $route, $handler);
    }

    public function delete(string $route, string $handler): void
    {
        $this->addRoute(self::DELETE, $route, $handler);
    }

    private function addRoute(string $method, string $route, string $handler): void
    {
        $key = $method . self::STATUS_DELIMITER . $route;
        $this->routes[$key] = $handler;
    }

    public function dispatch(ConfigInterface $config, string $request_method, string $request_uri): RouteHandler
    {
        $routes = $this->routes;
        $dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) use ($config, $routes) {
            foreach ($routes as $key => $value) {
                $keys = explode(self::STATUS_DELIMITER, $key);
                $httpMethod = $keys[0];
                $uris = explode(self::ROUTE_DELIMITER, $keys[1]);
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