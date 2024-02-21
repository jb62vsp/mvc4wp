<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Route;

use Mvc4Wp\Core\Library\Castable;

abstract class AbstractRouter implements RouterInterface
{
    use Castable, RouterTrait;
}