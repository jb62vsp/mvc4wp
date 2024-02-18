<?php declare(strict_types=1);
namespace System\Models;

use Error;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use System\Exception\ApplicationException;

#[CoversClass(CustomPostType::class)]
class CustomPostTypeTest extends TestCase
{
    public function test_construct01(): void
    {
        $obj = new CustomPostType('name', 'title');
        $this->assertNotNull($obj);
        $this->assertEquals('name', $obj->name);
        $this->assertEquals('title', $obj->title);
    }

    public function test_getName01(): void
    {
        $name = CustomPostType::getName(CustomPostTypeTestMockA::class);
        $this->assertEquals('mock_a', $name);
    }

    public function test_getName02(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('duplicate to set System\Models\CustomPostTypeTestMockB, name');
        CustomPostType::getName(CustomPostTypeTestMockB::class);
    }

    public function test_getName03(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Unknown named parameter $hoge');
        CustomPostType::getName(CustomPostTypeTestMockC::class);
    }

    public function test_getTitle01(): void
    {
        $name = CustomPostType::getTitle(CustomPostTypeTestMockA::class);
        $this->assertEquals('タイトルA', $name);
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