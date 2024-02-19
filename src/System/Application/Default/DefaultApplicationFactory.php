<?php declare(strict_types=1);
namespace Mvc4Wp\System\Application\Default;

use Mvc4Wp\System\Application\AbstractApplicationFactory;
use Mvc4Wp\System\Application\ApplicationInterface;
use Mvc4Wp\System\Config\Default\DefaultConfiguratorFactory;
use Mvc4Wp\System\Route\Default\DefaultRouterFactory;

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