<?php declare(strict_types=1);
namespace Mvc4Wp\System\Route\Default;

use Mvc4Wp\System\Route\AbstractRouterFactory;
use Mvc4Wp\System\Route\RouterInterface;

class DefaultRouterFactory extends AbstractRouterFactory
{
    public function create(array $args = []): RouterInterface
    {
        return new DefaultRouter();
    }
}