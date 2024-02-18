<?php declare(strict_types=1);
namespace System\Route;

class DefaultRouterFactory extends AbstractRouterFactory
{
    public function create(array $args = []): RouterInterface
    {
        return new DefaultRouter();
    }
}