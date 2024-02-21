<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Route\Default;

use Mvc4Wp\Core\Route\AbstractRouterFactory;
use Mvc4Wp\Core\Route\RouterInterface;

class DefaultRouterFactory extends AbstractRouterFactory
{
    public function create(array $args = []): RouterInterface
    {
        return new DefaultRouter();
    }
}