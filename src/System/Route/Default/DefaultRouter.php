<?php declare(strict_types=1);
namespace Mvc4Wp\System\Route\Default;

use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Route\AbstractRouter;

class DefaultRouter extends AbstractRouter
{
    use Cast, FastRouteRouterTrait;
}