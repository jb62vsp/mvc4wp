<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Order;

use Mvc4Wp\Core\Model\Repository\OrderInQuery;
use Mvc4Wp\Core\Model\Repository\Querable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostOrderQuerable::class)]
class PostOrderQuerableTest extends TestCase
{
    public function test_noOrder(): void
    {
        $obj = new PostOrderQuerableTestMockImpl();

        $actual = $obj
            ->noOrder()
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['none' => ['ASC', '']]], $actual);
    }

    public function test_orderByAuthor_noParam(): void
    {
        $obj = new PostOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByAuthor()
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['author' => ['ASC', '']]], $actual);
    }

    public function test_orderByAuthor_asc(): void
    {
        $obj = new PostOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByAuthor(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['author' => ['ASC', '']]], $actual);
    }

    public function test_orderByAuthor_desc(): void
    {
        $obj = new PostOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByAuthor(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['author' => ['DESC', '']]], $actual);
    }

    public function test_orderByTitle_noParam(): void
    {
        $obj = new PostOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByTitle()
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['title' => ['ASC', '']]], $actual);
    }

    public function test_orderByTitle_asc(): void
    {
        $obj = new PostOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByTitle(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['title' => ['ASC', '']]], $actual);
    }

    public function test_orderByTitle_desc(): void
    {
        $obj = new PostOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByAuthor(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['author' => ['DESC', '']]], $actual);
    }

    public function test_orderByType_noParam(): void
    {
        $obj = new PostOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByType()
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['type' => ['ASC', '']]], $actual);
    }

    public function test_orderByType_asc(): void
    {
        $obj = new PostOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByType(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['type' => ['ASC', '']]], $actual);
    }

    public function test_orderByType_desc(): void
    {
        $obj = new PostOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByType(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['type' => ['DESC', '']]], $actual);
    }

    public function test_orderByDate_noParam(): void
    {
        $obj = new PostOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByDate()
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['date' => ['ASC', '']]], $actual);
    }

    public function test_orderByDate_asc(): void
    {
        $obj = new PostOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByDate(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['date' => ['ASC', '']]], $actual);
    }

    public function test_orderByDate_desc(): void
    {
        $obj = new PostOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByDate(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['date' => ['DESC', '']]], $actual);
    }

    public function test_orderByModified_noParam(): void
    {
        $obj = new PostOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByModified()
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['modified' => ['ASC', '']]], $actual);
    }

    public function test_orderByModified_asc(): void
    {
        $obj = new PostOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByModified(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['modified' => ['ASC', '']]], $actual);
    }

    public function test_orderByModified_desc(): void
    {
        $obj = new PostOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByModified(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['modified' => ['DESC', '']]], $actual);
    }
}

class PostOrderQuerableTestMockImpl
{
    use Querable, PostOrderQuerable;
}