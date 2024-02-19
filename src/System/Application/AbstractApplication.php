<?php declare(strict_types=1);
namespace Wp4Mvc\System\Application;

use Wp4Mvc\System\Core\Cast;

abstract class AbstractApplication implements ApplicationInterface
{
    use Cast, ApplicationTrait;
}