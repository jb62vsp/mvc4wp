<?php declare(strict_types=1);
namespace System\Config;

abstract class AbstractConfiguratorFactory implements ConfiguratorFactoryInterface
{
    use ConfiguratorFactoryTrait;
}