<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library\Default;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Stringable;

#[CoversClass(DefaultMessager::class)]
class DefaultMessagerTest extends TestCase
{
    public function test_format_noParams(): void
    {
        $obj = new DefaultMessager('ja');

        $actual = $obj->format('hoge');
        $this->assertEquals('hoge', $actual);
    }

    public function test_format_singleParam(): void
    {
        $obj = new DefaultMessager('a');

        $actual = $obj->format('hoge: {0}', ['HOGE']);
        $this->assertEquals('hoge: HOGE', $actual);
    }

    public function test_format_multiParams(): void
    {
        $obj = new DefaultMessager('a');

        $actual = $obj->format('hoge: {0}, fuga: {1}, piyo: {2}', ['HOGE', 'FUGA', 'PIYO']);
        $this->assertEquals('hoge: HOGE, fuga: FUGA, piyo: PIYO', $actual);
    }

    public function test_format_multiParamsWithKey(): void
    {
        $obj = new DefaultMessager('a');

        $actual = $obj->format('hoge: {hoge}, fuga: {fuga}, piyo: {piyo}', [
            'hoge' => 'HOGE',
            'fuga' => 'FUGA',
            'piyo' => 'PIYO'
        ]);
        $this->assertEquals('hoge: HOGE, fuga: FUGA, piyo: PIYO', $actual);
    }

    public function test_format_Stringaable_noParams(): void
    {
        $obj = new DefaultMessager('a');
        $mock = new DefaultMessagerTestMock('hoge');

        $actual = $obj->format($mock);
        $this->assertEquals('hoge', $actual);
    }
}

class DefaultMessagerTestMock implements Stringable
{
    public function __construct(
        protected string $str,
    ) {
    }

    public function __toString(): string
    {
        return $this->str;
    }
}