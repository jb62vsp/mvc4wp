<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Route;

use Mvc4Wp\Core\Config\ConfiguratorInterface;

trait RouterTrait
{
    public const STATUS_DELIMITER = '`';

    public const ROUTE_DELIMITER = '|';

    public const GET = 'GET';

    public const POST = 'POST';

    public const PUT = 'PUT';

    public const DELETE = 'DELETE';

    protected array $routes = [];

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

    protected function addRoute(string $method, string $route, string $handler): void
    {
        $key = $method . self::STATUS_DELIMITER . $route;
        $this->routes[$key] = $handler;
    }
}