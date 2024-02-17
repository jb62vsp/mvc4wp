<?php declare(strict_types=1);
namespace System\Route;

use System\Core\Cast;

abstract class AbstractRouter implements RouterInterface
{
    use Cast, RouterTrait;
}