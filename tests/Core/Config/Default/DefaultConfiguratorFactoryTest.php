<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Config\Default;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DefaultConfiguratorFactory::class)]
class DefaultConfiguratorFactoryTest extends TestCase
{
    public function test_create(): void
    {
        $factory = new DefaultConfiguratorFactory();

        $actual = $factory->create();
        $this->assertInstanceOf(DefaultConfigurator::class, $actual);
    }
}