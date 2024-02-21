<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use ArgumentCountError;
use Error;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Mvc4Wp\Core\Exception\ApplicationException;

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

    public function test_getName(): void
    {
        $val = CustomField::getName(CustomFieldTestMockA::class, 'field_a');
        $this->assertEquals('test_slug', $val);
    }

    public function test_getName_tooFewArguments(): void
    {
        $this->expectException(ArgumentCountError::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Too few arguments to function Mvc4Wp\Core\Model\CustomField::__construct(),');
        CustomField::getName(CustomFieldTestMockA::class, 'field_b');
    }

    public function test_getName_notSet(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\CustomField" is not set to "Mvc4Wp\Core\Model\CustomFieldTestMockA::field_c"');
        CustomField::getName(CustomFieldTestMockA::class, 'field_c');
    }
    
    public function test_getName_repeated(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\CustomField" must not be repeated');
        CustomField::getName(CustomFieldTestMockB::class, 'field_a');
    }

    public function test_getTitle(): void
    {
        $val = CustomField::getTitle(CustomFieldTestMockA::class, 'field_a');
        $this->assertEquals('タイトルテスト', $val);
    }

    public function test_getType(): void
    {
        $val = CustomField::getType(CustomFieldTestMockA::class, 'field_a');
        $this->assertEquals('int', $val);
    }

    public function test_getName_unknown(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Unknown named parameter $hoge');
        CustomField::getName(CustomFieldTestMockC::class, 'field_a');
    }

    public function test_getName_notExist(): void
    {
        $this->expectException(ReflectionException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Property Mvc4Wp\Core\Model\CustomFieldTestMockC::$hoge does not exist');
        CustomField::getName(CustomFieldTestMockC::class, 'hoge');
    }

    public function test_getName_(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\CustomField" is not set to "Mvc4Wp\Core\Model\CustomFieldTestMockD::field_a"');
        CustomField::getName(CustomFieldTestMockD::class, 'field_a');
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

class CustomFieldTestMockD
{
    #[Field]
    public string $field_a;
}
