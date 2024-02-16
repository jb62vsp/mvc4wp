<?php declare(strict_types=1);
namespace System\Config;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Configrator::class)]
class ConfigTraitTest extends TestCase
{
    public function test_config(): void
    {
        $config = new ConfigTraitTestMockA();

        $config2 = $config->config();
        $this->assertNotNull($config2);
        $this->assertEquals($config, $config2);
        $this->assertEquals('false', $config->getConfig(CONFIG::DEBUG));
    }
}

class ConfigTraitTestMockA implements ConfigInterface
{
    use Configrator;

    public function __construct()
    {
        $this->addConfig(CONFIG::DEBUG, 'false');
    }
}