<?php declare(strict_types=1);
namespace System\Config;

abstract class AbstractConfiguratorFactory implements ConfiguratorFactoryInterface
{
    abstract public function create(array $args = []): ConfigInterface;
}