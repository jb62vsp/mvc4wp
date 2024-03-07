<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Route;

use Mvc4Wp\Core\Config\ConfiguratorInterface;

interface RouterInterface
{
    /**
     * @param string $route route rule.
     * @param list<class-string, string> $handler classname, methodname.
     */
    public function GET(string $route, array $handler): void;

    /**
     * @param string $route route rule.
     * @param list<class-string, string> $handler classname, methodname.
     */
    public function POST(string $route, array $handler): void;

    /**
     * @param string $route route rule.
     * @param list<class-string, string> $handler classname, methodname.
     */
    public function PUT(string $route, array $handler): void;

    /**
     * @param string $route route rule.
     * @param list<class-string, string> $handler classname, methodname.
     */
    public function DELETE(string $route, array $handler): void;

    public function dispatch(ConfiguratorInterface $config, string $request_method, string $request_uri): RouteHandler;
}