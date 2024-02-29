<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Route;

trait Routerable
{
    protected array $routes = [];

    public function GET(string $route, string $handler): void
    {
        $this->addRoute(HttpMethod::GET, $route, $handler);
    }

    public function POST(string $route, string $handler): void
    {
        $this->addRoute(HttpMethod::POST, $route, $handler);
    }

    public function PUT(string $route, string $handler): void
    {
        $this->addRoute(HttpMethod::PUT, $route, $handler);
    }

    public function DELETE(string $route, string $handler): void
    {
        $this->addRoute(HttpMethod::DELETE, $route, $handler);
    }

    protected function addRoute(string $method, string $route, string $handler): void
    {
        $key = $method . Delimiter::STATUS_DELIMITER . $route;
        $this->routes[$key] = $handler;
    }
}