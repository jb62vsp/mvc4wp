<?php declare(strict_types=1);
namespace System\Models;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use System\Exception\ApplicationException;

#[CoversClass(CustomPostType::class)]
class CustomPostTypeTest extends TestCase
{
    public function test_construct01(): void
    {
        $obj = new CustomPostType('slug', 'title');
        $this->assertNotNull($obj);
        $this->assertEquals('slug', $obj->slug);
        $this->assertEquals('title', $obj->title);
    }

    public function test_getSlug01(): void
    {
        $slug = CustomPostType::getSlug(CustomPostTypeTestMockA::class);
        $this->assertEquals('mock_a', $slug);
    }

    public function test_getSlug02(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('illegal to set CustomPostType.');
        CustomPostType::getSlug(CustomPostTypeTestMockB::class);
    }

    public function test_getSlug03(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('illegal parameters.');
        CustomPostType::getSlug(CustomPostTypeTestMockC::class);
    }

    public function test_getTitle01(): void
    {
        $slug = CustomPostType::getTitle(CustomPostTypeTestMockA::class);
        $this->assertEquals('タイトルA', $slug);
    }

    public function test_getTitle02(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('illegal to set CustomPostType.');
        CustomPostType::getTitle(CustomPostTypeTestMockB::class);
    }

    public function test_getTitle03(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('illegal parameters.');
        CustomPostType::getTitle(CustomPostTypeTestMockC::class);
    }
}

#[CustomPostType(slug: 'mock_a', title: 'タイトルA')]
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