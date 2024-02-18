<?php declare(strict_types=1);
namespace System\Config\Default;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use System\Config\CONFIG;

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