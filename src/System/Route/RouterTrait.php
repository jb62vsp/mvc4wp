<?php declare(strict_types=1);
namespace System\Route;

use FastRoute;
use FastRoute\RouteCollector;
use System\Config\CONFIG;
use System\Config\ConfigInterface;
use System\Core\HttpStatus;

trait RouterTrait
{
    private const GET = 'GET';

    private const POST = 'POST';

    private const PUT = 'PUT';

    private const DELETE = 'DELETE';

    private array $routes = [];

    public function router(): RouterInterface
    {
        return $this;
    }

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
        $key = $method . '|' . $route;
        $this->routes[$key] = $handler;
    }

    public function dispatch(ConfigInterface $config, string $request_method, string $request_uri): RouteHandler
    {
        $routes = $this->routes;
        $dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) use ($config, $routes) {
            foreach ($routes as $key => $value) {
                $keys = explode('|', $key);
                $r->addRoute($keys[0], $keys[1], $config->getConfig(CONFIG::CONTROLLER_NAMESPACE) . '\\' . $value);
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

// trait RouterTrait
// {
//     private const GET = 'GET';

//     private const POST = 'POST';

//     private const PUT = 'PUT';

//     private const DELETE = 'DELETE';

//     private array $routes = [
//         self::GET => [],
//         self::POST => [],
//         self::PUT => [],
//         self::DELETE => [],
//     ];

//     public function router(): RouterInterface
//     {
//         return $this;
//     }

//     public function all(): array
//     {
//         return $this->routes;
//     }

//     /*
//      * --------------------------------------------------------------------
//      * setting section
//      * --------------------------------------------------------------------
//      */
//     public function get(string $uri, string $signature): void
//     {
//         $this->addRoute(self::GET, $uri, $signature);
//     }

//     public function post(string $uri, string $signature): void
//     {
//         $this->addRoute(self::POST, $uri, $signature);
//     }

//     public function put(string $uri, string $signature): void
//     {
//         $this->addRoute(self::PUT, $uri, $signature);
//     }

//     public function delete(string $uri, string $signature): void
//     {
//         $this->addRoute(self::DELETE, $uri, $signature);
//     }

//     // private function addRoute(string $method, string $uri, string $signature): void
//     // {
//     //     $this->routes[$method][$uri] = $signature;
//     // }

//     private function addRoute(string $method, string $uri, string $signature): void
//     {
//         $segments = array_values(array_filter(explode('/', $uri), function ($x) {
//             return $x !== '';
//         }));
//         $this->routes[$method] = self::reduceRoute($segments, $signature, $this->routes[$method]);
//     }

//     private static function reduceRoute(array $segments, string $signature, array $acc): array|string
//     {
//         if (count($segments) === 0) {
//             return $signature;
//         }
//         $acc[$segments[0]] = self::reduceRoute(array_slice($segments, 1), $signature, $acc);
//         return $acc;
//     }

//     /*
//      * --------------------------------------------------------------------
//      * routing section
//      * --------------------------------------------------------------------
//      */

//     public function existRoute(ConfigInterface $config, string $request_method, string $uri): bool
//     {
//         $key = strtoupper($request_method) . '|' . $uri;
//         $route = $this->routes[$key];
//         return !is_null($route);
//     }

//     public function route(ConfigInterface $config, string $request_method, string $uri): Route
//     {
//         return new Route(strtoupper($request_method), $uri, [], ""); // TODO
//         // $key = strtoupper($request_method) . '|' . $uri;
//         // $route = $this->routes[$key];
//         // return $route;

//         // TODO: routing
//         // $exploded = explode('/', $uri);
//         // $filtered = array_values(array_filter($exploded, function ($var) {
//         //     return $var !== '';
//         // }));
//         // if (count($filtered) > 0) {
//         //     if (array_key_exists($filtered[0], self::ROUTES[$classification])) {
//         //         $shifted = $filtered;
//         //         array_shift($shifted);
//         //         HTTP::Response(200, true, false);
//         //         Mvc::run(self::ROUTES[$classification][$filtered[0]], '', true, ...$shifted);
//         //     } else {
//         //         return false;
//         //     }
//         // } else {
//         //     return false;
//         // }
//     }
// }