<?php declare(strict_types=1);
namespace System\Config;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DefaultConfigurator::class)]
class DefaultConfiguratorTest extends TestCase
{
    public function test_config(): void
    {
        $config = new DefaultConfigurator();

        $config->add(CONFIG::DEBUG, 'true');
        $this->assertEquals('true', $config->get(CONFIG::DEBUG));
    }
}