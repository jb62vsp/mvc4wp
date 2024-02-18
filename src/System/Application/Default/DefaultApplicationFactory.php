<?php declare(strict_types=1);
namespace System\Application\Default;

use System\Application\AbstractApplicationFactory;
use System\Application\ApplicationInterface;

class DefaultApplicationFactory extends AbstractApplicationFactory
{
    public function create(array $args = []): ApplicationInterface
    {
        return new DefaultApplication();
    }
}