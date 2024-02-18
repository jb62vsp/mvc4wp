<?php declare(strict_types=1);
namespace System\Application;

class DefaultApplicationFactory extends AbstractApplicationFactory
{
    public function create(array $args = []): ApplicationInterface
    {
        return new Application();
    }
}