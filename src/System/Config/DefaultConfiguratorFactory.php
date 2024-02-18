<?php declare(strict_types=1);
namespace System\Config;

class DefaultConfiguratorFactory extends AbstractConfiguratorFactory
{
    public function create(array $args = []): ConfigInterface
    {
        return new DefaultConfigurator();
    }
}