<?php declare(strict_types=1);
namespace System\Models;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use System\Exception\ApplicationException;

#[CoversClass(PostType::class)]
class PostTypeTest extends TestCase
{
    public function test_construct01(): void
    {
        $obj = new PostType('test');
        $this->assertNotNull($obj);
        $this->assertEquals('test', $obj->name);
    }

    public function test_construct02(): void
    {
        $obj = new PostType(name: 'test');
        $this->assertNotNull($obj);
        $this->assertEquals('test', $obj->name);
    }

    public function test_getPostType01(): void
    {
        $post_type = PostType::getPostType(PostTypeTestMockA::class);
        $this->assertEquals('mock_a', $post_type);
    }

    public function test_getPostType02(): void
    {
        $post_type = PostType::getPostType(PostTypeTestMockB::class);
        $this->assertEquals('mock_b', $post_type);
    }

    public function test_getPostType03(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('illegal to set PostType.');
        PostType::getPostType(PostTypeTestMockC::class);
    }

    public function test_getPostType04(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('illegal parameters.');
        PostType::getPostType(PostTypeTestMockD::class);
    }
}

#[PostType('mock_a')]
class PostTypeTestMockA
{
}

#[PostType(name: 'mock_b')]
class PostTypeTestMockB
{
}


#[PostType('a')]
#[PostType('b')]
class PostTypeTestMockC
{
}

#[PostType(hoge: 'a', fuga: 'b')]
class PostTypeTestMockD
{
}