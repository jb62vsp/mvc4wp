<?php declare(strict_types=1);
namespace System\Application\Default;

use System\Application\AbstractApplicationFactory;
use System\Application\ApplicationInterface;
use System\Config\Default\DefaultConfiguratorFactory;
use System\Route\DefaultRouterFactory;

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