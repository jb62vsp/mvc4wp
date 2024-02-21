<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Application\Default;

use Mvc4Wp\Core\Application\AbstractApplicationFactory;
use Mvc4Wp\Core\Application\ApplicationInterface;
use Mvc4Wp\Core\Config\Default\DefaultConfiguratorFactory;
use Mvc4Wp\Core\Route\Default\DefaultRouterFactory;

class DefaultApplicationFactory extends AbstractApplicationFactory
{
    public function create(array $args = []): ApplicationInterface
    {
        return new DefaultApplication(
            (new DefaultConfiguratorFactory())->create($args),
            (new DefaultRouterFactory())->create($args),
        );
    }
}