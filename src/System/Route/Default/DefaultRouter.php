<?php declare(strict_types=1);
namespace System\Route\Default;

use System\Core\Cast;
use System\Route\AbstractRouter;
use System\Route\RouterTrait;

class DefaultRouter extends AbstractRouter
{
    use Cast, FastRouteRouterTrait, RouterTrait;
}