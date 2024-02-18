<?php declare(strict_types=1);
namespace System\Config\Default;

use System\Config\AbstractConfiguratorFactory;
use System\Config\ConfigInterface;

class DefaultConfiguratorFactory extends AbstractConfiguratorFactory
{
    public function create(array $args = []): ConfigInterface
    {
        return new DefaultConfigurator($args);
    }
}