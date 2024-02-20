<?php declare(strict_types=1);
namespace Mvc4Wp\System\Config;

interface ConfiguratorFactoryInterface
{
    public function create(array $args = []): ConfiguratorInterface;
}