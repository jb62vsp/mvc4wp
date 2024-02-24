<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Attribute;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Field::class)]
class FieldTest extends TestCase
{
    public function test_construct01(): void
    {
        $obj = new Field();
        $this->assertNotNull($obj);
    }

    public function test_getFieldFields01(): void
    {
        $fields = Field::getAttributedProperties(FieldTestMockA::class);
        $this->assertCount(3, $fields);
    }

    public function test_getFieldFieldNames01(): void
    {
        $names = Field::getAttributedPropertyNames(FieldTestMockA::class);
        $this->assertCount(3, $names);
        $this->assertEquals('field_a', $names[0]);
    }

    // TODO: MockB
}

class FieldTestMockA
{
    #[Field]
    public string $field_a;

    public string $field_b;

    #[Field]
    private string $field_c;

    #[Field]
    protected string $field_d;
}

class FieldTestMockB
{
    #[Field]
    #[Field]
    public string $field_a;

    #[Field(hoge: 'hoge', fuga: 'fuga')]
    public string $field_b;
}