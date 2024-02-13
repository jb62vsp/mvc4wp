<?php declare(strict_types=1);
namespace System\Application;

use System\Config\ConfigInterface;
use System\Core\HttpStatus;
use System\Route\RouteHandler;
use System\Route\RouterInterface;

trait ApplicationTrait
{
    public function execute(ConfigInterface $config, RouterInterface $router): void
    {
        /** @var RouteHandler $route */
        $route = $router->dispatch($config, $_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

        if ($route->status !== HttpStatus::OK) {
            return;
        }

        $signatures = explode('::', $route->signature);
        if (count($signatures) < 2) {
            return;
        }

        $class = $signatures[0];
        if (!class_exists($class)) {
            return;
        }

        $controller = new $class($this);
        $method = $signatures[1];
        if (!method_exists($controller, $method)) {
            return;
        }

        if (method_exists($controller, 'init')) {
            $controller->init();
        }

        $controller->{$method}($route->args);
    }
}