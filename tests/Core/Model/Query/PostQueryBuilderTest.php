<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query;

use Mvc4Wp\Core\Exception\ApplicationException;
use Mvc4Wp\Core\Model\Attribute\PostType;
use Mvc4Wp\Core\Model\Query\PostType\PostTypeExpr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostQueryBuilder::class)]
class PostQueryBuilderTest extends TestCase
{
    public function test_asModel_single(): void
    {
        $obj = new PostQueryBuilder();

        $actual = $obj
            ->asModel(PostQueryBuilderTestMockA::class)
            ->getExpressions();
        $this->assertEquals([PostTypeExpr::class => ['hoge']], $actual);
    }

    public function test_asModel_double(): void
    {
        $obj = new PostQueryBuilder();

        $actual = $obj
            ->asModel(PostQueryBuilderTestMockA::class, PostQueryBuilderTestMockB::class)
            ->getExpressions();
        $this->assertEquals([PostTypeExpr::class => ['hoge', 'fuga']], $actual);
    }

    public function test_asModel_chain(): void
    {
        $obj = new PostQueryBuilder();

        $actual = $obj
            ->asModel(PostQueryBuilderTestMockA::class, PostQueryBuilderTestMockB::class)
            ->asModel(PostQueryBuilderTestMockC::class)
            ->getExpressions();
        $this->assertCount(1, $actual);
        $this->assertEquals([PostTypeExpr::class => ['hoge', 'fuga', 'piyo']], $actual);
    }

    public function test_asModel_noModel(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\Attribute\PostType" is not set to "Mvc4Wp\Core\Model\Query\PostQueryBuilderTestMockD');

        $obj = new PostQueryBuilder();
        $obj->asModel(
            PostQueryBuilderTestMockA::class,
            PostQueryBuilderTestMockB::class,
            PostQueryBuilderTestMockC::class,
            PostQueryBuilderTestMockD::class,
        );
    }
}

#[PostType("hoge")]
class PostQueryBuilderTestMockA
{
}

#[PostType("fuga")]
class PostQueryBuilderTestMockB
{
}

#[PostType("piyo")]
class PostQueryBuilderTestMockC
{
}

class PostQueryBuilderTestMockD
{
}