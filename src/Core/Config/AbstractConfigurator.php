<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Config;

use Mvc4Wp\Core\Library\Cast;

abstract class AbstractConfigurator implements ConfiguratorInterface
{
    use Cast;
}