<?php declare(strict_types=1);
namespace System\Route;

use System\Core\Cast;

class DefaultRouter extends AbstractRouter
{
    use Cast, FastRouteRouterTrait, RouterTrait;
}