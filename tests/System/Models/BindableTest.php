<?php declare(strict_types=1);
namespace System\Models;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use System\Exception\ApplicationException;

#[CoversClass(Bindable::class)]
class BindableTest extends TestCase
{
    public function test_construct01(): void
    {
        $obj = new Bindable();
        $this->assertNotNull($obj);
        $this->assertNull($obj->default_value);
    }

    public function test_construct02(): void
    {
        $obj = new Bindable('test');
        $this->assertNotNull($obj);
        $this->assertNotNull($obj->default_value);
        $this->assertEquals('test', $obj->default_value);
    }

    public function test_getDefaultValue01(): void
    {
        $val = Bindable::getDefaultValue(BindableTestMockA::class, 'field_a');
        $this->assertNull($val);
    }

    public function test_getDefaultValue02(): void
    {
        $val = Bindable::getDefaultValue(BindableTestMockA::class, 'field_b');
        $this->assertNotNull($val);
        $this->assertEquals(0, $val);
    }

    public function test_getDefaultValue03(): void
    {
        $val = Bindable::getDefaultValue(BindableTestMockA::class, 'field_c');
        $this->assertNotNull($val);
        $this->assertEquals('abc', $val);
    }

    public function test_getDefaultValue04(): void
    {
        $val = Bindable::getDefaultValue(BindableTestMockA::class, 'field_d');
        $this->assertNull($val);
    }

    public function test_getDefaultValue05(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('illegal to set BindableField.');
        Bindable::getDefaultValue(BindableTestMockB::class, 'field_a');
    }

    public function test_getDefaultValue06(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('illegal parameters.');
        Bindable::getDefaultValue(BindableTestMockB::class, 'field_b');
    }

    public function test_getBindableFields01(): void
    {
        $fields = Bindable::getBindableFields(BindableTestMockA::class);
        $this->assertCount(3, $fields);
    }

    public function test_getBindableFieldNames01(): void
    {
        $names = Bindable::getBindableFieldNames(BindableTestMockA::class);
        $this->assertCount(3, $names);
        $this->assertEquals('field_a', $names[0]);
        $this->assertEquals('field_b', $names[1]);
        $this->assertEquals('field_c', $names[2]);
    }
}

class BindableTestMockA
{
    #[Bindable]
    public string $field_a;

    #[Bindable(default_value: 0)]
    public int $field_b;

    #[Bindable('abc')]
    public float $field_c;

    public string $field_d;

    #[Bindable]
    private string $field_e;

    #[Bindable]
    protected string $field_f;
}

class BindableTestMockB
{
    #[Bindable]
    #[Bindable]
    public string $field_a;

    #[Bindable(hoge: 'hoge', fuga: 'fuga')]
    public string $field_b;
}