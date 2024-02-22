<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\PostType;

use Mvc4Wp\Core\Exception\ApplicationException;
use Mvc4Wp\Core\Model\PostType;
use Mvc4Wp\Core\Model\Query\PostType\PostTypeExpr;
use Mvc4Wp\Core\Model\Query\Querable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostTypeQuerable::class)]
class PostTypeQuerableTest extends TestCase
{
    public function test_asModel_single(): void
    {
        $obj = new PostTypeQuerableTestMockImpl();

        $actual = $obj
            ->asModel(PostTypeQuerableTestMockA::class)
            ->getExpressions();
        $this->assertEquals([PostTypeExpr::class => ['hoge']], $actual);
    }

    public function test_asModel_double(): void
    {
        $obj = new PostTypeQuerableTestMockImpl();

        $actual = $obj
            ->asModel(PostTypeQuerableTestMockA::class, PostTypeQuerableTestMockB::class)
            ->getExpressions();
        $this->assertEquals([PostTypeExpr::class => ['hoge', 'fuga']], $actual);
    }

    public function test_asModel_chain(): void
    {
        $obj = new PostTypeQuerableTestMockImpl();

        $actual = $obj
            ->asModel(PostTypeQuerableTestMockA::class, PostTypeQuerableTestMockB::class)
            ->asModel(PostTypeQuerableTestMockC::class)
            ->getExpressions();
        $this->assertCount(1, $actual);
        $this->assertEquals([PostTypeExpr::class => ['hoge', 'fuga', 'piyo']], $actual);
    }

    public function test_asModel_noModel(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\PostType" is not set to "Mvc4Wp\Core\Model\Query\PostType\PostTypeQuerableTestMockD');

        $obj = new PostTypeQuerableTestMockImpl();
        $obj->asModel(
            PostTypeQuerableTestMockA::class,
            PostTypeQuerableTestMockB::class,
            PostTypeQuerableTestMockC::class,
            PostTypeQuerableTestMockD::class,
        );
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