<?php declare(strict_types=1);
namespace Mvc4Wp\System\Application;

use Mvc4Wp\System\Core\Cast;

abstract class AbstractApplication implements ApplicationInterface
{
    use Cast;
}