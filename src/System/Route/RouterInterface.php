<?php declare(strict_types=1);
namespace System\Route;

use System\Config\ConfigInterface;

interface RouterInterface
{
    public const STATUS_DELIMITER = '`';

    public const ROUTE_DELIMITER = '|';

    public const GET = 'GET';

    public const POST = 'POST';

    public const PUT = 'PUT';

    public const DELETE = 'DELETE';

    public function get(string $route, string $handler): void;

    public function post(string $route, string $handler): void;

    public function put(string $route, string $handler): void;

    public function delete(string $route, string $handler): void;

    public function dispatch(ConfigInterface $config, string $request_method, string $request_uri): RouteHandler;
}