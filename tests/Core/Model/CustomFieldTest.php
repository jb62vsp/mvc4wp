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
        $obj = new CustomField('title', 'int');
        $this->assertNotNull($obj);
        $this->assertEquals('title', $obj->title);
        $this->assertEquals('int', $obj->type);
    }

    public function test_getTitle(): void
    {
        $val = CustomField::getTitle(CustomFieldTestMockA::class, 'field_a');
        $this->assertEquals('タイトルテスト', $val);
    }

    public function test_getTitle_tooFewArguments(): void
    {
        $this->expectException(ArgumentCountError::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Too few arguments to function Mvc4Wp\Core\Model\CustomField::__construct(),');
        CustomField::getTitle(CustomFieldTestMockA::class, 'field_b');
    }

    public function test_getTitle_notSet(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\CustomField" is not set to "Mvc4Wp\Core\Model\CustomFieldTestMockA::field_c"');
        CustomField::getTitle(CustomFieldTestMockA::class, 'field_c');
    }
    
    public function test_getTitle_repeated(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\CustomField" must not be repeated');
        CustomField::getTitle(CustomFieldTestMockB::class, 'field_a');
    }

    public function test_getType(): void
    {
        $val = CustomField::getType(CustomFieldTestMockA::class, 'field_a');
        $this->assertEquals('int', $val);
    }

    public function test_getTitle_unknown(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Unknown named parameter $hoge');
        CustomField::getTitle(CustomFieldTestMockC::class, 'field_a');
    }

    public function test_getTitle_notExist(): void
    {
        $this->expectException(ReflectionException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Property Mvc4Wp\Core\Model\CustomFieldTestMockC::$hoge does not exist');
        CustomField::getTitle(CustomFieldTestMockC::class, 'hoge');
    }

    public function test_getTitle_(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\CustomField" is not set to "Mvc4Wp\Core\Model\CustomFieldTestMockD::field_a"');
        CustomField::getTitle(CustomFieldTestMockD::class, 'field_a');
    }
}

class CustomFieldTestMockA
{
    #[CustomField(title: 'タイトルテスト', type: 'int')]
    public string $field_a;

    #[CustomField]
    public string $field_b;

    public string $field_c;

    #[CustomField(title: 'title')]
    public string $field_d;
}

class CustomFieldTestMockB
{
    #[CustomField(title: 'title1')]
    #[CustomField(title: 'title2')]
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
