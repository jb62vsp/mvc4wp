<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\PostType;

use Mvc4Wp\Core\Exception\ApplicationException;
use Mvc4Wp\Core\Model\Attribute\PostType;
use Mvc4Wp\Core\Model\Query\PostType\PostTypeExpr;
use Mvc4Wp\Core\Model\Query\Querable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostTypeQuerable::class)]
class PostTypeQuerableTest extends TestCase
{
    public function test_asEntity_single(): void
    {
        $obj = new PostTypeQuerableTestMockImpl();

        $actual = $obj
            ->asEntity(PostTypeQuerableTestMockA::class)
            ->getExpressions();
        $this->assertEquals([PostTypeExpr::class => ['hoge']], $actual);
    }

    public function test_asEntity_double(): void
    {
        $obj = new PostTypeQuerableTestMockImpl();

        $actual = $obj
            ->asEntity(PostTypeQuerableTestMockA::class, PostTypeQuerableTestMockB::class)
            ->getExpressions();
        $this->assertEquals([PostTypeExpr::class => ['hoge', 'fuga']], $actual);
    }

    public function test_asEntity_chain(): void
    {
        $obj = new PostTypeQuerableTestMockImpl();

        $actual = $obj
            ->asEntity(PostTypeQuerableTestMockA::class, PostTypeQuerableTestMockB::class)
            ->asEntity(PostTypeQuerableTestMockC::class)
            ->getExpressions();
        $this->assertCount(1, $actual);
        $this->assertEquals([PostTypeExpr::class => ['hoge', 'fuga', 'piyo']], $actual);
    }

    public function test_asEntity_noEntity(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\Attribute\PostType" is not set to "Mvc4Wp\Core\Model\Query\PostType\PostTypeQuerableTestMockD');

        $obj = new PostTypeQuerableTestMockImpl();
        $obj->asEntity(
            PostTypeQuerableTestMockA::class,
            PostTypeQuerableTestMockB::class,
            PostTypeQuerableTestMockC::class,
            PostTypeQuerableTestMockD::class,
        );
    }

    public function test_asPost_single(): void
    {
        $obj = new PostTypeQuerableTestMockImpl();

        $actual = $obj
            ->asPost()
            ->getExpressions();
        $this->assertEquals([PostTypeExpr::class => ['post']], $actual);
    }

    public function test_asPage_single(): void
    {
        $obj = new PostTypeQuerableTestMockImpl();

        $actual = $obj
            ->asPage()
            ->getExpressions();
        $this->assertEquals([PostTypeExpr::class => ['page']], $actual);
    }

    public function test_asRevision_single(): void
    {
        $obj = new PostTypeQuerableTestMockImpl();

        $actual = $obj
            ->asRevision()
            ->getExpressions();
        $this->assertEquals([PostTypeExpr::class => ['revision']], $actual);
    }

    public function test_asAttachment_single(): void
    {
        $obj = new PostTypeQuerableTestMockImpl();

        $actual = $obj
            ->asAttachment()
            ->getExpressions();
        $this->assertEquals([PostTypeExpr::class => ['attachment']], $actual);
    }

    public function test_chain(): void
    {
        $obj = new PostTypeQuerableTestMockImpl();

        $actual = $obj
            ->asPost()
            ->asPage()
            ->asRevision()
            ->asAttachment()
            ->asEntity(PostTypeQuerableTestMockA::class, PostTypeQuerableTestMockB::class)
            ->asEntity(PostTypeQuerableTestMockC::class)
            ->getExpressions();
        $this->assertEquals([PostTypeExpr::class => ['post', 'page', 'revision', 'attachment', 'hoge', 'fuga', 'piyo']], $actual);
    }
}

#[PostType("hoge")]
class PostTypeQuerableTestMockA
{
}

#[PostType("fuga")]
class PostTypeQuerableTestMockB
{
}

#[PostType("piyo")]
class PostTypeQuerableTestMockC
{
}

class PostTypeQuerableTestMockD
{
}

class PostTypeQuerableTestMockImpl
{
    use Querable, PostTypeQuerable;
}