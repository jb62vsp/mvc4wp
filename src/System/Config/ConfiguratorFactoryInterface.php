<?php declare(strict_types=1);
namespace System\Config;

interface ConfiguratorFactoryInterface
{
    public function create(array $args = []): ConfigInterface;
}