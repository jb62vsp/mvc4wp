<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Route;

use Mvc4Wp\Core\Config\ConfiguratorInterface;

interface RouterInterface
{
    public function GET(string $route, string $handler): void;

    public function POST(string $route, string $handler): void;

    public function PUT(string $route, string $handler): void;

    public function DELETE(string $route, string $handler): void;

    public function dispatch(ConfiguratorInterface $config, string $request_method, string $request_uri): RouteHandler;
}