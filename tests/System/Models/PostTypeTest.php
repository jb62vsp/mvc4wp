<?php declare(strict_types=1);
namespace System\Models;

use Attribute;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ReflectionAttribute;
use ReflectionClass;

#[CoversClass(PostType::class)]
class PostTypeTest extends TestCase
{
    public function test_getAttributes01(): void
    {
        $ref = new ReflectionClass(PostTypeTestMockA::class);
        $attrs = $ref->getAttributes(PostType::class);

        $this->assertCount(1, $attrs);
        $this->assertInstanceOf(ReflectionAttribute::class, $attrs[0]);
        $this->assertEquals('System\\Models\\PostType', $attrs[0]->getName());
        $this->assertEquals(Attribute::TARGET_CLASS, $attrs[0]->getTarget());
        $this->assertCount(1, $attrs[0]->getArguments());
        $this->assertArrayHasKey('post_type', $attrs[0]->getArguments());
        $this->assertEquals('mock', $attrs[0]->getArguments()['post_type']);
    }
}

#[PostType(post_type: 'mock')]
class PostTypeTestMockA
{
}