<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Route\Default;

use Mvc4Wp\Core\Route\RouterFactoryInterface;
use Mvc4Wp\Core\Route\RouterInterface;

class DefaultRouterFactory implements RouterFactoryInterface
{
    public static function create(array $args = []): RouterInterface
    {
        return new DefaultRouter();
    }
}