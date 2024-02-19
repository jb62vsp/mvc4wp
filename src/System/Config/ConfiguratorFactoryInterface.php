<?php declare(strict_types=1);
namespace Wp4Mvc\System\Config;

interface ConfiguratorFactoryInterface
{
    public function create(array $args = []): ConfigInterface;
}