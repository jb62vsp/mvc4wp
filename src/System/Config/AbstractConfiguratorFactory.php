<?php declare(strict_types=1);
namespace Mvc4Wp\System\Config;

use Mvc4Wp\System\Core\Cast;

abstract class AbstractConfiguratorFactory implements ConfiguratorFactoryInterface
{
    use Cast;

    abstract public function create(array $args = []): ConfiguratorInterface;
}