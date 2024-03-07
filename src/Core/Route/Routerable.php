<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Route;

trait Routerable
{
    protected array $routes = [];

    public function GET(string $route, array $handler): void
    {
        $this->addRoute(HttpMethod::GET, $route, $handler);
    }

    public function POST(string $route, array $handler): void
    {
        $this->addRoute(HttpMethod::POST, $route, $handler);
    }

    public function PUT(string $route, array $handler): void
    {
        $this->addRoute(HttpMethod::PUT, $route, $handler);
    }

    public function DELETE(string $route, array $handler): void
    {
        $this->addRoute(HttpMethod::DELETE, $route, $handler);
    }

    protected function addRoute(string $method, string $route, array $handler): void
    {
        $key = $method . Delimiter::STATUS_DELIMITER . $route;
        if (count($handler) > 1) {
            $this->routes[$key] = $handler[0] . '::' . $handler[1];
        } else {
            $this->routes[$key] = $handler[0] . '::index';
        }
    }
}