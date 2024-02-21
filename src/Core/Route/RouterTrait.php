<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Route;

use Mvc4Wp\Core\Config\ConfiguratorInterface;

trait RouterTrait
{
    protected array $routes = [];

    public function get(string $route, string $handler): void
    {
        $this->addRoute(RouterInterface::GET, $route, $handler);
    }

    public function post(string $route, string $handler): void
    {
        $this->addRoute(RouterInterface::POST, $route, $handler);
    }

    public function put(string $route, string $handler): void
    {
        $this->addRoute(RouterInterface::PUT, $route, $handler);
    }

    public function delete(string $route, string $handler): void
    {
        $this->addRoute(RouterInterface::DELETE, $route, $handler);
    }

    protected function addRoute(string $method, string $route, string $handler): void
    {
        $key = $method . RouterInterface::STATUS_DELIMITER . $route;
        $this->routes[$key] = $handler;
    }

    abstract public function dispatch(ConfiguratorInterface $config, string $request_method, string $request_uri): RouteHandler;
}