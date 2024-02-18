<?php declare(strict_types=1);
namespace System\Route\Default;

use System\Route\AbstractRouterFactory;
use System\Route\RouterInterface;

class DefaultRouterFactory extends AbstractRouterFactory
{
    public function create(array $args = []): RouterInterface
    {
        return new DefaultRouter();
    }
}