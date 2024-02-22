<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query;

use Mvc4Wp\Core\Exception\ApplicationException;
use Mvc4Wp\Core\Model\PostType;
use Mvc4Wp\Core\Model\Query\Author\AuthorExpr;
use Mvc4Wp\Core\Model\Query\Author\AuthorInExpr;
use Mvc4Wp\Core\Model\Query\Author\AuthorNameExpr;
use Mvc4Wp\Core\Model\Query\Author\AuthorNotInExpr;
use Mvc4Wp\Core\Model\Query\PostType\PostTypeExpr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractQueryBuilder::class)]
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
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\PostType" is not set to "Mvc4Wp\Core\Model\Query\PostQueryBuilderTestMockD');

        $obj = new PostQueryBuilder();
        $obj->asModel(
            PostQueryBuilderTestMockA::class,
            PostQueryBuilderTestMockB::class,
            PostQueryBuilderTestMockC::class,
            PostQueryBuilderTestMockD::class,
        );
    }

    public function test_byAuthor_single(): void
    {
        $obj = new PostQueryBuilder();

        $actual = $obj->byAuthor(1)->getExpressions();
        $this->assertEquals([AuthorExpr::class => [1]], $actual);
    }

    public function test_byAuthor_chain(): void
    {
        $obj = new PostQueryBuilder();

        $actual = $obj
            ->byAuthor(1)
            ->byAuthor(2)
            ->getExpressions();
        $this->assertEquals([AuthorExpr::class => [2]], $actual);
    }

    public function test_byAuthorName_single(): void
    {
        $obj = new PostQueryBuilder();

        $actual = $obj->byAuthorName('hoge')->getExpressions();
        $this->assertEquals([AuthorNameExpr::class => ['hoge']], $actual);
    }

    public function test_byAuthorName_chain(): void
    {
        $obj = new PostQueryBuilder();

        $actual = $obj
            ->byAuthorName('hoge')
            ->byAuthorName('fuga')
            ->getExpressions();
        $this->assertEquals([AuthorNameExpr::class => ['fuga']], $actual);
    }

    public function test_byAuthorIn_single(): void
    {
        $obj = new PostQueryBuilder();

        $actual = $obj
            ->byAuthorIn(1)
            ->getExpressions();
        $this->assertEquals([AuthorInExpr::class => [1]], $actual);
    }

    public function test_byAuthorIn_multi(): void
    {
        $obj = new PostQueryBuilder();

        $actual = $obj
            ->byAuthorIn(1, 2, 3)
            ->getExpressions();
        $this->assertEquals([AuthorInExpr::class => [1, 2, 3]], $actual);
    }
    public function test_byAuthorIn_chain(): void
    {
        $obj = new PostQueryBuilder();

        $actual = $obj
            ->byAuthorIn(1, 2)
            ->byAuthorIn(3)
            ->getExpressions();
        $this->assertEquals([AuthorInExpr::class => [1, 2, 3]], $actual);
    }

    public function test_byAuthorNotIn_single(): void
    {
        $obj = new PostQueryBuilder();

        $actual = $obj
            ->byAuthorNotIn(1)
            ->getExpressions();
        $this->assertEquals([AuthorNotInExpr::class => [1]], $actual);
    }

    public function test_byAuthorNotIn_multi(): void
    {
        $obj = new PostQueryBuilder();

        $actual = $obj
            ->byAuthorNotIn(1, 2, 3)
            ->getExpressions();
        $this->assertEquals([AuthorNotInExpr::class => [1, 2, 3]], $actual);
    }
    public function test_byAuthorNotIn_chain(): void
    {
        $obj = new PostQueryBuilder();

        $actual = $obj
            ->byAuthorNotIn(1, 2)
            ->byAuthorNotIn(3)
            ->getExpressions();
        $this->assertEquals([AuthorNotInExpr::class => [1, 2, 3]], $actual);
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