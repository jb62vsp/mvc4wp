<?php declare(strict_types=1);
namespace Wp4Mvc\System\Route\Default;

use Wp4Mvc\System\Core\Cast;
use Wp4Mvc\System\Route\AbstractRouter;

class DefaultRouter extends AbstractRouter
{
    use Cast, FastRouteRouterTrait;
}