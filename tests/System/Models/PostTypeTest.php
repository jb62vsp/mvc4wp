<?php declare(strict_types=1);
namespace System\Models;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use System\Exception\ApplicationException;

#[CoversClass(PostType::class)]
class PostTypeTest extends TestCase
{
    public function test_construct(): void
    {
        $obj = new PostType();
        $this->assertNotNull($obj);
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
        $this->expectExceptionMessage('duplicate PostType.');
        PostType::getPostType(PostTypeTestMockC::class);
    }

    public function test_getPostType04(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('duplicate parameters.');
        PostType::getPostType(PostTypeTestMockD::class);
    }
}

#[PostType(post_type: 'mock_a')]
class PostTypeTestMockA
{
}

#[PostType('mock_b')]
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