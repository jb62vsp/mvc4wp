<?php declare(strict_types=1);
namespace System\Models;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use System\Exception\ApplicationException;

#[CoversClass(CustomField::class)]
class CustomFieldTest extends TestCase
{
    public function test_construct01(): void
    {
        $obj = new CustomField('slug', 'title');
        $this->assertNotNull($obj);
        $this->assertEquals('slug', $obj->slug);
        $this->assertEquals('title', $obj->title);
    }

    public function test_getSlug01(): void
    {
        $val = CustomField::getSlug(CustomFieldTestMockA::class, 'field_a');
        $this->assertEquals('test_slug', $val);
    }

    public function test_getSlug02(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('illegal parameters.');
        CustomField::getSlug(CustomFieldTestMockA::class, 'field_b');
    }

    public function test_getSlug03(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('illegal to set CustomField.');
        CustomField::getSlug(CustomFieldTestMockA::class, 'field_c');
    }

    public function test_getTitle01(): void
    {
        $val = CustomField::getTitle(CustomFieldTestMockA::class, 'field_a');
        $this->assertEquals('タイトルテスト', $val);
    }

    public function test_getTitle02(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('illegal parameters.');
        CustomField::getSlug(CustomFieldTestMockA::class, 'field_b');
    }

    public function test_getTitle03(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('illegal to set CustomField.');
        CustomField::getTitle(CustomFieldTestMockA::class, 'field_c');
    }
}

class CustomFieldTestMockA
{
    #[CustomField(slug: 'test_slug', title: 'タイトルテスト')]
    public string $field_a;

    #[CustomField]
    public string $field_b;

    public string $field_c;
}

class CustomFieldTestMockB
{
    #[CustomField]
    #[CustomField]
    public string $field_a;

    #[CustomField(hoge: 'hoge', fuga: 'fuga')]
    public string $field_b;
}