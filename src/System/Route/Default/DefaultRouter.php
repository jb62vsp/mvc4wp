<?php declare(strict_types=1);
namespace System\Route\Default;

use System\Core\Cast;
use System\Route\AbstractRouter;

class DefaultRouter extends AbstractRouter
{
    use Cast, FastRouteRouterTrait;
}