<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(TypeUtils::class)]
class TypeUtilsTest extends TestCase
{
    public function test_hasKey_arrayHasValue(): void
    {
        $actual = TypeUtils::hasKey([
            'hoge' => 'HOGE',
            'fuga' => 'FUGA',
            'piyo' => 'PIYO',
        ], 'hoge');
        $this->assertTrue($actual);
    }

    public function test_hasKey_objectHasValue(): void
    {
        $obj = new stdClass();
        $obj->hoge = 'HOGE';
        $obj->fuga = 'FUGA';
        $obj->piyo = 'PIYO';
        $actual = TypeUtils::hasKey($obj, 'hoge');
        $this->assertTrue($actual);
    }

    public function test_hasKey_arrayHasNoValue(): void
    {
        $actual = TypeUtils::hasKey([
            'hoge' => 'HOGE',
            'fuga' => 'FUGA',
            'piyo' => 'PIYO',
        ], 'foo');
        $this->assertFalse($actual);
    }

    public function test_hasKey_objectHasNoValue(): void
    {
        $obj = new stdClass();
        $obj->hoge = 'HOGE';
        $obj->fuga = 'FUGA';
        $obj->piyo = 'PIYO';
        $actual = TypeUtils::hasKey($obj, 'foo');
        $this->assertFalse($actual);
    }

    public function test_getValue_array(): void
    {
        $actual = TypeUtils::getValue([
            'hoge' => 'HOGE',
            'fuga' => 'FUGA',
            'piyo' => 'PIYO',
        ], 'hoge');
        $this->assertEquals('HOGE', $actual);
    }

    public function test_getValue_object(): void
    {
        $obj = new stdClass();
        $obj->hoge = 'HOGE';
        $obj->fuga = 'FUGA';
        $obj->piyo = 'PIYO';
        $actual = TypeUtils::getValue($obj, 'hoge');
        $this->assertEquals('HOGE', $actual);
    }

    public function test_getValue_nextedArray(): void
    {
        $actual = TypeUtils::getValue([
            'hoge' => ['HOGE'],
            'fuga' => 'FUGA',
            'piyo' => 'PIYO',
        ], 'hoge');
        $this->assertEquals('HOGE', $actual);
    }

    public function test_getValue_arrayNoKey(): void
    {
        $actual = TypeUtils::getValue([
            'hoge' => 'HOGE',
            'fuga' => 'FUGA',
            'piyo' => 'PIYO',
        ], 'foo');
        $this->assertNull($actual);
    }

    public function test_getValue_objectNoKey(): void
    {
        $obj = new stdClass();
        $obj->hoge = 'HOGE';
        $obj->fuga = 'FUGA';
        $obj->piyo = 'PIYO';
        $actual = TypeUtils::getValue($obj, 'foo');
        $this->assertNull($actual);
    }

    public function test_typedValue_null(): void
    {
        $actual = TypeUtils::typedValue('string', null);
        $this->assertNull($actual);

        $actual = TypeUtils::typedValue('int', null);
        $this->assertNull($actual);

        $actual = TypeUtils::typedValue('float', null);
        $this->assertNull($actual);

        $actual = TypeUtils::typedValue('bool', null);
        $this->assertNull($actual);

        $actual = TypeUtils::typedValue('null', null);
        $this->assertNull($actual);
    }

    public function test_typedValue_string(): void
    {
        $actual = TypeUtils::typedValue('string', 'hoge');
        $this->assertEquals('hoge', $actual);

        $actual = TypeUtils::typedValue('int', 'hoge');
        $this->assertEquals(0, $actual);

        $actual = TypeUtils::typedValue('float', 'hoge');
        $this->assertEquals(0.0, $actual);

        $actual = TypeUtils::typedValue('bool', '');
        $this->assertFalse($actual);

        $actual = TypeUtils::typedValue('bool', 'hoge');
        $this->assertTrue($actual);

        $actual = TypeUtils::typedValue('null', 'hoge');
        $this->assertNull($actual);
    }

    public function test_typedValue_int(): void
    {
        $actual = TypeUtils::typedValue('string', 1);
        $this->assertEquals('1', $actual);

        $actual = TypeUtils::typedValue('int', 1);
        $this->assertEquals(1, $actual);

        $actual = TypeUtils::typedValue('float', 1);
        $this->assertEquals(1.0, $actual);

        $actual = TypeUtils::typedValue('bool', 0);
        $this->assertFalse($actual);

        $actual = TypeUtils::typedValue('bool', 1);
        $this->assertTrue($actual);

        $actual = TypeUtils::typedValue('null', 1);
        $this->assertNull($actual);
    }

    public function test_typedValue_float(): void
    {
        $actual = TypeUtils::typedValue('string', 1.2);
        $this->assertEquals('1.2', $actual);

        $actual = TypeUtils::typedValue('int', 1.2);
        $this->assertEquals(1, $actual);

        $actual = TypeUtils::typedValue('int', 1.9);
        $this->assertEquals(1, $actual);

        $actual = TypeUtils::typedValue('float', 1.2);
        $this->assertEquals(1.2, $actual);

        $actual = TypeUtils::typedValue('bool', 0.0);
        $this->assertFalse($actual);

        $actual = TypeUtils::typedValue('bool', 1.2);
        $this->assertTrue($actual);

        $actual = TypeUtils::typedValue('null', 1.2);
        $this->assertNull($actual);
    }

    public function test_typedValue_bool_true(): void
    {
        $actual = TypeUtils::typedValue('string', true);
        $this->assertEquals('1', $actual);

        $actual = TypeUtils::typedValue('int', true);
        $this->assertEquals(1, $actual);

        $actual = TypeUtils::typedValue('float', true);
        $this->assertEquals(1.0, $actual);

        $actual = TypeUtils::typedValue('bool', true);
        $this->assertTrue($actual);

        $actual = TypeUtils::typedValue('null', true);
        $this->assertNull($actual);
    }

    public function test_typedValue_bool_false(): void
    {
        $actual = TypeUtils::typedValue('string', false);
        $this->assertEquals('', $actual);

        $actual = TypeUtils::typedValue('int', false);
        $this->assertEquals(0, $actual);

        $actual = TypeUtils::typedValue('float', false);
        $this->assertEquals(0.0, $actual);

        $actual = TypeUtils::typedValue('bool', false);
        $this->assertFalse($actual);

        $actual = TypeUtils::typedValue('null', false);
        $this->assertNull($actual);
    }

    public function test_untypedValue_string(): void
    {
        $actual = TypeUtils::untypedValue('string', 'hoge');
        $this->assertEquals('hoge', $actual);

        $actual = TypeUtils::untypedValue('string', 1);
        $this->assertEquals('1', $actual);

        $actual = TypeUtils::untypedValue('string', 1.2);
        $this->assertEquals('1.2', $actual);

        $actual = TypeUtils::untypedValue('string', true);
        $this->assertEquals('1', $actual);

        $actual = TypeUtils::untypedValue('string', false);
        $this->assertEquals('', $actual);

        $actual = TypeUtils::untypedValue('string', null);
        $this->assertEquals('', $actual);
    }

    public function test_untypedValue_int(): void
    {
        $actual = TypeUtils::untypedValue('int', 'hoge');
        $this->assertEquals('hoge', $actual);

        $actual = TypeUtils::untypedValue('int', 1);
        $this->assertEquals('1', $actual);

        $actual = TypeUtils::untypedValue('int', 1.2);
        $this->assertEquals('1.2', $actual);

        $actual = TypeUtils::untypedValue('int', true);
        $this->assertEquals('1', $actual);

        $actual = TypeUtils::untypedValue('int', false);
        $this->assertEquals('', $actual);

        $actual = TypeUtils::untypedValue('int', null);
        $this->assertEquals('', $actual);
    }

    public function test_untypedValue_float(): void
    {
        $actual = TypeUtils::untypedValue('float', 'hoge');
        $this->assertEquals('hoge', $actual);

        $actual = TypeUtils::untypedValue('float', 1);
        $this->assertEquals('1', $actual);

        $actual = TypeUtils::untypedValue('float', 1.2);
        $this->assertEquals('1.2', $actual);

        $actual = TypeUtils::untypedValue('float', true);
        $this->assertEquals('1', $actual);

        $actual = TypeUtils::untypedValue('float', false);
        $this->assertEquals('', $actual);

        $actual = TypeUtils::untypedValue('float', null);
        $this->assertEquals('', $actual);
    }

    public function test_untypedValue_bool(): void
    {
        $actual = TypeUtils::untypedValue('bool', 'hoge');
        $this->assertEquals('hoge', $actual);

        $actual = TypeUtils::untypedValue('bool', 1);
        $this->assertEquals('1', $actual);

        $actual = TypeUtils::untypedValue('bool', 1.2);
        $this->assertEquals('1.2', $actual);

        $actual = TypeUtils::untypedValue('bool', true);
        $this->assertEquals('1', $actual);

        $actual = TypeUtils::untypedValue('bool', false);
        $this->assertEquals('', $actual);

        $actual = TypeUtils::untypedValue('bool', null);
        $this->assertEquals('', $actual);
    }
}