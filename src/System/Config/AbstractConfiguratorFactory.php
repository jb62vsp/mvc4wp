<?php declare(strict_types=1);
namespace Wp4Mvc\System\Config;

abstract class AbstractConfiguratorFactory implements ConfiguratorFactoryInterface
{
    abstract public function create(array $args = []): ConfigInterface;
}