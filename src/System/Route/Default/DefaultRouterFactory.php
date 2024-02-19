<?php declare(strict_types=1);
namespace Wp4Mvc\System\Route\Default;

use Wp4Mvc\System\Route\AbstractRouterFactory;
use Wp4Mvc\System\Route\RouterInterface;

class DefaultRouterFactory extends AbstractRouterFactory
{
    public function create(array $args = []): RouterInterface
    {
        return new DefaultRouter();
    }
}