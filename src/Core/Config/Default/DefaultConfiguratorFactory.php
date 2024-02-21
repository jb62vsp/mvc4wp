<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Config\Default;

use Mvc4Wp\Core\Config\AbstractConfiguratorFactory;
use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Library\Cast;

class DefaultConfiguratorFactory extends AbstractConfiguratorFactory
{
    use Cast;

    public function create(array $args = []): ConfiguratorInterface
    {
        return new DefaultConfigurator();
    }
}