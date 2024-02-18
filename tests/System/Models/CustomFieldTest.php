<?php declare(strict_types=1);
namespace System\Models;

use Error;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use System\Exception\ApplicationException;

#[CoversClass(CustomField::class)]
#[CoversClass(AttributeTrait::class)]
class CustomFieldTest extends TestCase
{
    public function test_construct01(): void
    {
        $obj = new CustomField('slug', 'title', 'int');
        $this->assertNotNull($obj);
        $this->assertEquals('slug', $obj->name);
        $this->assertEquals('title', $obj->title);
        $this->assertEquals('int', $obj->type);
    }

    public function test_getName01(): void
    {
        $val = CustomField::getName(CustomFieldTestMockA::class, 'field_a');
        $this->assertEquals('test_slug', $val);
    }

    public function test_getName02(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('not set System\Models\CustomField::name, System\Models\CustomFieldTestMockA::field_b');
        CustomField::getName(CustomFieldTestMockA::class, 'field_b');
    }

    public function test_getName03(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('not set System\Models\CustomFieldTestMockA::field_c');
        CustomField::getName(CustomFieldTestMockA::class, 'field_c');
    }
    
    public function test_getName04(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('duplicate to set System\Models\CustomFieldTestMockB::field_a');
        CustomField::getName(CustomFieldTestMockB::class, 'field_a');
    }

    public function test_getTitle01(): void
    {
        $val = CustomField::getTitle(CustomFieldTestMockA::class, 'field_a');
        $this->assertEquals('タイトルテスト', $val);
    }

    public function test_getType01(): void
    {
        $val = CustomField::getType(CustomFieldTestMockA::class, 'field_a');
        $this->assertEquals('int', $val);
    }

    public function test_getType02(): void
    {
        $val = CustomField::getType(CustomFieldTestMockA::class, 'field_d');
        $this->assertEquals('TEXT', $val);
    }

    public function test_hoge01(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Unknown named parameter $hoge');
        CustomField::getName(CustomFieldTestMockC::class, 'field_a');
    }

    public function test_notExistFieldName(): void
    {
        $this->expectException(ReflectionException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Property System\Models\CustomFieldTestMockC::$hoge does not exist');
        CustomField::getName(CustomFieldTestMockC::class, 'hoge');
    }
}

class CustomFieldTestMockA
{
    #[CustomField(name: 'test_slug', title: 'タイトルテスト', type: 'int')]
    public string $field_a;

    #[CustomField]
    public string $field_b;

    public string $field_c;

    #[CustomField(name: 'name', title: 'title')]
    public string $field_d;

}

class CustomFieldTestMockB
{
    #[CustomField(name: 'name1', title: 'title1')]
    #[CustomField(name: 'name2', title: 'title2')]
    public string $field_a;
}

class CustomFieldTestMockC
{
    #[CustomField(hoge: 'hoge', fuga: 'fuga')]
    public string $field_a;
}