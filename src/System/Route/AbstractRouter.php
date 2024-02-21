<?php declare(strict_types=1);
namespace Mvc4Wp\System\Route;

use Mvc4Wp\System\Library\Cast;

abstract class AbstractRouter implements RouterInterface
{
    use Cast, RouterTrait;
}