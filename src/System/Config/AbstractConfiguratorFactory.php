<?php declare(strict_types=1);
namespace Mvc4Wp\System\Config;

abstract class AbstractConfiguratorFactory implements ConfiguratorFactoryInterface
{
    abstract public function create(array $args = []): ConfigInterface;
}