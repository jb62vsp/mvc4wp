<?php declare(strict_types=1);
namespace Wp4Mvc\System\Application\Default;

use Wp4Mvc\System\Application\AbstractApplicationFactory;
use Wp4Mvc\System\Application\ApplicationInterface;
use Wp4Mvc\System\Config\Default\DefaultConfiguratorFactory;
use Wp4Mvc\System\Route\Default\DefaultRouterFactory;

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