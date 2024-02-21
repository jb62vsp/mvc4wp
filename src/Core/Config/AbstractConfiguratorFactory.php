<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Config;

use Mvc4Wp\Core\Library\Castable;

abstract class AbstractConfiguratorFactory implements ConfiguratorFactoryInterface
{
    use Castable;

    abstract public function create(array $args = []): ConfiguratorInterface;
}