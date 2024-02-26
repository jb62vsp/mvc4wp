<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Language\Default;

use Mvc4Wp\Core\Language\MessagerFactoryInterface;
use Mvc4Wp\Core\Language\MessagerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DefaultMessager::class)]
class DefaultMessagerTest extends TestCase
{
    public function test_message_noParams(): void
    {
        $obj = DefaultMessagerTestMockA::create();

        $actual = $obj->message('hoge.fuga.piyo');
        $this->assertEquals('PIYO', $actual);
    }

    public function test_message_singleParamWithIndex(): void
    {
        $obj = DefaultMessagerTestMockA::create();

        $actual = $obj->message('foo.bar.buz', ['HOGE']);
        $this->assertEquals('buzbuzbuz: HOGE', $actual);
    }

    public function test_message_singleParamWithKey(): void
    {
        $obj = DefaultMessagerTestMockA::create();

        $actual = $obj->message('hoge.Fuga', ['var' => 'FUGA']);
        $this->assertEquals('fugafuga: FUGA', $actual);
    }

    public function test_message_multiParams(): void
    {
        $obj = DefaultMessagerTestMockA::create();

        $actual = $obj->message('foo.bar.Buz', ['HOGE', 'FUGA', 'PIYO']);
        $this->assertEquals('BuzBuz: HOGEFUGAPIYO', $actual);
    }

    public function test_message_noFile(): void
    {
        $obj = DefaultMessagerTestMockCoreNone::create();

        $actual = $obj->message('hoge');
        $this->assertFalse($actual);
    }

    public function test_message_noApp(): void
    {
        $obj = DefaultMessagerTestMockAppNone::create();

        $actual = $obj->message('hoge');
        $this->assertEquals('HOGE', $actual);
    }
    
    public function test_message_noAppNoCore(): void
    {
        $obj = DefaultMessagerTestMockCoreNone::create();

        $actual = $obj->message('hoge');
        $this->assertFalse($actual);
    }

    public function test_message_messagesNone(): void
    {
        $obj = DefaultMessagerTestMockMessagesNone::create();

        $actual = $obj->message('hoge');
        $this->assertFalse($actual);
    }

    public function test_message_keyEmpty(): void
    {
        $obj = DefaultMessagerTestMockA::create();

        $actual = $obj->message('');
        $this->assertFalse($actual);
    }

    public function test_message_keyNotFound(): void
    {
        $obj = DefaultMessagerTestMockA::create();

        $actual = $obj->message('numeri');
        $this->assertFalse($actual);
    }
}

class DefaultMessagerTestMockA implements MessagerFactoryInterface
{
    public static function create(array $args = []): MessagerInterface
    {
        return new DefaultMessager(
            'ja',
            __DIR__ . '/DefaultMessagerTestFileAppA.php',
            __DIR__ . '/DefaultMessagerTestFileCoreA.php'
        );
    }
}

class DefaultMessagerTestMockAppNone implements MessagerFactoryInterface
{
    public static function create(array $args = []): MessagerInterface
    {
        return new DefaultMessager(
            'ja',
            __DIR__ . '/DefaultMessagerTestFileAppNone.php',
            __DIR__ . '/DefaultMessagerTestFileCoreA.php'
        );
    }
}

class DefaultMessagerTestMockCoreNone implements MessagerFactoryInterface
{
    public static function create(array $args = []): MessagerInterface
    {
        return new DefaultMessager(
            'ja',
            __DIR__ . '/DefaultMessagerTestFileAppNone.php',
            __DIR__ . '/DefaultMessagerTestFileCoreNone.php'
        );
    }
}

class DefaultMessagerTestMockMessagesNone implements MessagerFactoryInterface
{
    public static function create(array $args = []): MessagerInterface
    {
        return new DefaultMessager(
            'ja',
            __DIR__ . '/DefaultMessagerTestFileMessagesNone.php',
            __DIR__ . '/DefaultMessagerTestFileCoreNone.php'
        );
    }
}