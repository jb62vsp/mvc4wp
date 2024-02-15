<?php declare(strict_types=1);
namespace System\Models;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use System\Exception\ApplicationException;

#[CoversClass(BindableField::class)]
class BindableFieldTest extends TestCase
{
    public function test_construct01(): void
    {
        $obj = new BindableField();
        $this->assertNotNull($obj);
        $this->assertNull($obj->default_value);
    }

    public function test_construct02(): void
    {
        $obj = new BindableField('test');
        $this->assertNotNull($obj);
        $this->assertNotNull($obj->default_value);
        $this->assertEquals('test', $obj->default_value);
    }

    public function test_getDefaultValue01(): void
    {
        $val = BindableField::getDefaultValue(BindableFieldTestMockA::class, 'field_a');
        $this->assertNull($val);
    }

    public function test_getDefaultValue02(): void
    {
        $val = BindableField::getDefaultValue(BindableFieldTestMockA::class, 'field_b');
        $this->assertNotNull($val);
        $this->assertEquals(0, $val);
    }

    public function test_getDefaultValue03(): void
    {
        $val = BindableField::getDefaultValue(BindableFieldTestMockA::class, 'field_c');
        $this->assertNotNull($val);
        $this->assertEquals('abc', $val);
    }

    public function test_getDefaultValue04(): void
    {
        $val = BindableField::getDefaultValue(BindableFieldTestMockA::class, 'field_d');
        $this->assertNull($val);
    }

    public function test_getDefaultValue05(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('illegal to set BindableField.');
        BindableField::getDefaultValue(BindableFieldTestMockB::class, 'field_a');
    }

    public function test_getDefaultValue06(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('illegal parameters.');
        BindableField::getDefaultValue(BindableFieldTestMockB::class, 'field_b');
    }

    public function test_getBindableFields01(): void
    {
        $fields = BindableField::getBindableFields(BindableFieldTestMockA::class);
        $this->assertCount(3, $fields);
    }

    public function test_getBindableFieldNames01(): void
    {
        $names = BindableField::getBindableFieldNames(BindableFieldTestMockA::class);
        $this->assertCount(3, $names);
        $this->assertEquals('field_a', $names[0]);
        $this->assertEquals('field_b', $names[1]);
        $this->assertEquals('field_c', $names[2]);
    }
}

class BindableFieldTestMockA
{
    #[BindableField]
    public string $field_a;

    #[BindableField(default_value: 0)]
    public int $field_b;

    #[BindableField('abc')]
    public float $field_c;

    public string $field_d;

    #[BindableField]
    private string $field_e;

    #[BindableField]
    protected string $field_f;
}

class BindableFieldTestMockB
{
    #[BindableField]
    #[BindableField]
    public string $field_a;

    #[BindableField(hoge: 'hoge', fuga: 'fuga')]
    public string $field_b;
}