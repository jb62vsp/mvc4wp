<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Route;

use Mvc4Wp\Core\Library\Cast;

abstract class AbstractRouter implements RouterInterface
{
    use Cast, RouterTrait;
}