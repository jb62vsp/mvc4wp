<?php declare(strict_types=1);
namespace Wp4Mvc\System\Config\Default;

use Wp4Mvc\System\Config\AbstractConfiguratorFactory;
use Wp4Mvc\System\Config\ConfigInterface;

class DefaultConfiguratorFactory extends AbstractConfiguratorFactory
{
    public function create(array $args = []): ConfigInterface
    {
        return new DefaultConfigurator();
    }
}