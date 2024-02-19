<?php declare(strict_types=1);
namespace Wp4Mvc\System\Route;

use Wp4Mvc\System\Core\Cast;

abstract class AbstractRouter implements RouterInterface
{
    use Cast, RouterTrait;
}