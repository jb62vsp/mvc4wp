<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Application;

use Mvc4Wp\Core\Library\Cast;

abstract class AbstractApplication implements ApplicationInterface
{
    use Cast;
}