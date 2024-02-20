<?php declare(strict_types=1);
namespace Mvc4Wp\System\Config\Default;

use Mvc4Wp\System\Config\AbstractConfiguratorFactory;
use Mvc4Wp\System\Config\ConfiguratorInterface;
use Mvc4Wp\System\Core\Cast;

class DefaultConfiguratorFactory extends AbstractConfiguratorFactory
{
    use Cast;

    public function create(array $args = []): ConfiguratorInterface
    {
        return new DefaultConfigurator();
    }
}