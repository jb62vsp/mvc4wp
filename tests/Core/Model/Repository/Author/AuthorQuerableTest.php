<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\Model;
use Mvc4Wp\Core\Model\Repository\Author\AuthorExpr;
use Mvc4Wp\Core\Model\Repository\Author\AuthorInExpr;
use Mvc4Wp\Core\Model\Repository\Author\AuthorNameExpr;
use Mvc4Wp\Core\Model\Repository\Author\AuthorNotInExpr;
use Mvc4Wp\Core\Model\Repository\Author\AuthorQuerable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AuthorQuerable::class)]
class AuthorQuerableTest extends TestCase
{
    public function test_byAuthor_single(): void
    {
        $obj = new AuthorQuerableTestMockA();

        $actual = $obj->byAuthor(1)->getExpressions();
        $this->assertEquals([AuthorExpr::class => [1]], $actual);
    }

    public function test_byAuthor_chain(): void
    {
        $obj = new AuthorQuerableTestMockA();

        $actual = $obj
            ->byAuthor(1)
            ->byAuthor(2)
            ->getExpressions();
        $this->assertEquals([AuthorExpr::class => [2]], $actual);
    }

    public function test_byAuthorName_single(): void
    {
        $obj = new AuthorQuerableTestMockA();

        $actual = $obj->byAuthorName('hoge')->getExpressions();
        $this->assertEquals([AuthorNameExpr::class => ['hoge']], $actual);
    }

    public function test_byAuthorName_chain(): void
    {
        $obj = new AuthorQuerableTestMockA();

        $actual = $obj
            ->byAuthorName('hoge')
            ->byAuthorName('fuga')
            ->getExpressions();
        $this->assertEquals([AuthorNameExpr::class => ['fuga']], $actual);
    }

    public function test_byAuthorIn_single(): void
    {
        $obj = new AuthorQuerableTestMockA();

        $actual = $obj
            ->byAuthorIn(1)
            ->getExpressions();
        $this->assertEquals([AuthorInExpr::class => [1]], $actual);
    }

    public function test_byAuthorIn_multi(): void
    {
        $obj = new AuthorQuerableTestMockA();

        $actual = $obj
            ->byAuthorIn(1, 2, 3)
            ->getExpressions();
        $this->assertEquals([AuthorInExpr::class => [1, 2, 3]], $actual);
    }
    public function test_byAuthorIn_chain(): void
    {
        $obj = new AuthorQuerableTestMockA();

        $actual = $obj
            ->byAuthorIn(1, 2)
            ->byAuthorIn(3)
            ->getExpressions();
        $this->assertEquals([AuthorInExpr::class => [1, 2, 3]], $actual);
    }

    public function test_byAuthorNotIn_single(): void
    {
        $obj = new AuthorQuerableTestMockA();

        $actual = $obj
            ->byAuthorNotIn(1)
            ->getExpressions();
        $this->assertEquals([AuthorNotInExpr::class => [1]], $actual);
    }

    public function test_byAuthorNotIn_multi(): void
    {
        $obj = new AuthorQuerableTestMockA();

        $actual = $obj
            ->byAuthorNotIn(1, 2, 3)
            ->getExpressions();
        $this->assertEquals([AuthorNotInExpr::class => [1, 2, 3]], $actual);
    }
    public function test_byAuthorNotIn_chain(): void
    {
        $obj = new AuthorQuerableTestMockA();

        $actual = $obj
            ->byAuthorNotIn(1, 2)
            ->byAuthorNotIn(3)
            ->getExpressions();
        $this->assertEquals([AuthorNotInExpr::class => [1, 2, 3]], $actual);
    }
}

/**
 * @template T of Model
 */
class AuthorQuerableTestMockA
{
    /**
     * @use AuthorQuerable<T>
     */
    use Querable, AuthorQuerable;
}