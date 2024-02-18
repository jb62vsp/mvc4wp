<?php declare(strict_types=1);
namespace System\Application;

use System\Core\Cast;

abstract class AbstractApplication implements ApplicationInterface
{
    use Cast, ApplicationTrait;
}