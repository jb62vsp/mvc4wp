<?php declare(strict_types=1);
namespace Mvc4Wp\System\Model;

use Error;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Mvc4Wp\System\Exception\ApplicationException;

#[CoversClass(CustomPostType::class)]
#[CoversClass(AttributeTrait::class)]
class CustomPostTypeTest extends TestCase
{
    public function test_construct01(): void
    {
        $obj = new CustomPostType('name', 'title');
        $this->assertNotNull($obj);
        $this->assertEquals('name', $obj->name);
        $this->assertEquals('title', $obj->title);
    }

    public function test_accessible(): void
    {
        $attr = CustomPostType::getClassAttribute(CustomPostTypeTestMockA::class);
        $this->assertEquals('mock_a', $attr->name);
        $this->assertEquals('タイトルA', $attr->title);
    }

    public function test_duplicateError(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('duplicate to set System\Model\CustomPostTypeTestMockB');
        CustomPostType::getClassAttribute(CustomPostTypeTestMockB::class);
    }

    public function test_illegalParameterError(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Unknown named parameter $hoge');
        CustomPostType::getClassAttribute(CustomPostTypeTestMockC::class);
    }
}

#[CustomPostType(name: 'mock_a', title: 'タイトルA')]
class CustomPostTypeTestMockA
{
}

#[CustomPostType('a')]
#[CustomPostType('b')]
class CustomPostTypeTestMockB
{
}

#[CustomPostType(hoge: 'a', fuga: 'b')]
class CustomPostTypeTestMockC
{
}