<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Route;

use Mvc4Wp\Core\Config\ConfiguratorInterface;

interface RouterInterface
{
    public function get(string $route, string $handler): void;

    public function post(string $route, string $handler): void;

    public function put(string $route, string $handler): void;

    public function delete(string $route, string $handler): void;

    public function dispatch(ConfiguratorInterface $config, string $request_method, string $request_uri): RouteHandler;
}