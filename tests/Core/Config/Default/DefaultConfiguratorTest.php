<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Config\Default;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DefaultConfigurator::class)]
class DefaultConfiguratorTest extends TestCase
{
    private array $test_values = [
        'hoge' => [
            'fuga' => [
                'piyo' => 'PIYO',
            ],
        ],
        'foo' => [
            'bar' => [
                'buz' => 'BUZ',
            ]
        ],
    ];

    public function test_get_noKey(): void
    {
        $config = new DefaultConfigurator();

        $actual = $config->get('TEST');
        $this->assertNull($actual);
    }

    public function test_get_singleKey(): void
    {
        $config = new DefaultConfigurator();
        $config->add('hoge', 'HOGE');

        $actual = $config->get('hoge');
        $this->assertEquals('HOGE', $actual);
    }

    public function test_get_singleValueWithMultiKey(): void
    {
        $config = new DefaultConfigurator();
        $config->add('TEST', $this->test_values);

        $actual = $config->get('TEST.hoge.fuga.piyo');
        $this->assertEquals('PIYO', $actual);
    }

    public function test_get_multiValueWithMultiKey(): void
    {
        $config = new DefaultConfigurator();
        $config->add('TEST', $this->test_values);

        $actual = $config->get('TEST.hoge.fuga');
        $this->assertEquals(['piyo' => 'PIYO'], $actual);
    }

    public function test_get_noSingleKey(): void
    {
        $config = new DefaultConfigurator();
        $config->add('TEST', $this->test_values);

        $actual = $config->get('TEST.fuga');
        $this->assertNull($actual);
    }

    public function test_get_noMultiKey(): void
    {
        $config = new DefaultConfigurator();
        $config->add('TEST', $this->test_values);

        $actual = $config->get('TEST.hoge.bar');
        $this->assertNull($actual);
    }

    public function test_set_singleKey(): void
    {
        $config = new DefaultConfigurator();
        $config->add('hoge', 'HOGE');
        $config->set('hoge', 'Hoge');

        $actual = $config->get('hoge');
        $this->assertEquals('Hoge', $actual);
    }

    public function test_set_multiKey(): void
    {
        $config = new DefaultConfigurator();
        $config->add('TEST', $this->test_values);
        $config->set('TEST.hoge.fuga.piyo', 'Piyo');

        $actual = $config->get('TEST');
        $this->assertEquals([
            'hoge' => [
                'fuga' => [
                    'piyo' => 'Piyo',
                ],
            ],
            'foo' => [
                'bar' => [
                    'buz' => 'BUZ',
                ]
            ],
        ], $actual);
    }

    public function test_set_noSingleKey(): void
    {
        $config = new DefaultConfigurator();
        $config->add('TEST', $this->test_values);
        $config->set('TEST.bar', 'Bar');

        $actual = $config->get('TEST');
        $this->assertEquals([
            'hoge' => [
                'fuga' => [
                    'piyo' => 'PIYO',
                ],
            ],
            'foo' => [
                'bar' => [
                    'buz' => 'BUZ',
                ]
            ],
            'bar' => 'Bar',
        ], $actual);
    }

    public function test_set_noMultiKey(): void
    {
        $config = new DefaultConfigurator();
        $config->add('TEST', $this->test_values);
        $config->set('TEST.hoge.fuga.buz', 'Buz');

        $actual = $config->get('TEST');
        $this->assertEquals([
            'hoge' => [
                'fuga' => [
                    'piyo' => 'PIYO',
                    'buz' => 'Buz',
                ],
            ],
            'foo' => [
                'bar' => [
                    'buz' => 'BUZ',
                ]
            ],
        ], $actual);
    }
}