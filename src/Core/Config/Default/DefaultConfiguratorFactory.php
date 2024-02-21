<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Config\Default;

use Mvc4Wp\Core\Config\AbstractConfiguratorFactory;
use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Library\Castable;

class DefaultConfiguratorFactory extends AbstractConfiguratorFactory
{
    use Castable;

    public function create(array $args = []): ConfiguratorInterface
    {
        return new DefaultConfigurator();
    }
}