<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Error;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

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

    public function test_getName01(): void
    {
        $post_type = PostType::getName(PostTypeTestMockA::class);
        $this->assertEquals('mock_a', $post_type);
    }

    public function test_getName02(): void
    {
        $post_type = PostType::getName(PostTypeTestMockB::class);
        $this->assertEquals('mock_b', $post_type);
    }

    public function test_getName03(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\PostType" must not be repeated');
        PostType::getName(PostTypeTestMockC::class);
    }

    public function test_getName04(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Unknown named parameter $hoge');
        PostType::getName(PostTypeTestMockD::class);
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