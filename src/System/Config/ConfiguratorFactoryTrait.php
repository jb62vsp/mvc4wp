<?php declare(strict_types=1);
namespace System\Config;

trait ConfiguratorFactoryTrait
{
    abstract public function create(array $args = []): ConfigInterface;
}