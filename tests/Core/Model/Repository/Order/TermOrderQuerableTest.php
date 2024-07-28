<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Order;

use Mvc4Wp\Core\Model\Repository\OrderInQuery;
use Mvc4Wp\Core\Model\Repository\Querable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TermOrderQuerable::class)]
class TermOrderQuerableTest extends TestCase
{
    public function test_orderBy_noParam(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderBy('hoge')
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['hoge' => 'ASC']], $actual);
    }

    public function test_orderBy_asc(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderBy('hoge', OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['hoge' => 'ASC']], $actual);
    }

    public function test_orderBy_desc(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderBy('hoge', OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['hoge' => 'DESC']], $actual);
    }

    public function test_orderByName_noParam(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByName()
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['name' => 'ASC']], $actual);
    }

    public function test_orderByName_asc(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByName(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['name' => 'ASC']], $actual);
    }

    public function test_orderByName_desc(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByName(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['name' => 'DESC']], $actual);
    }

    public function test_orderBySlug_noParam(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderBySlug()
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['slug' => 'ASC']], $actual);
    }

    public function test_orderBySlug_asc(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderBySlug(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['slug' => 'ASC']], $actual);
    }

    public function test_orderBySlug_desc(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderBySlug(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['slug' => 'DESC']], $actual);
    }

    public function test_orderByTermGroup_noParam(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByTermGroup()
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['term_group' => 'ASC']], $actual);
    }

    public function test_orderByTermGroup_asc(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByTermGroup(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['term_group' => 'ASC']], $actual);
    }

    public function test_orderByTermGroup_desc(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByTermGroup(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['term_group' => 'DESC']], $actual);
    }

    public function test_orderByTermID_noParam(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByTermID()
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['term_id' => 'ASC']], $actual);
    }

    public function test_orderByTermID_asc(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByTermID(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['term_id' => 'ASC']], $actual);
    }

    public function test_orderByTermID_desc(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByTermID(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['term_id' => 'DESC']], $actual);
    }

    public function test_orderByID_noParam(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByID()
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['id' => 'ASC']], $actual);
    }

    public function test_orderByID_asc(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByID(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['id' => 'ASC']], $actual);
    }

    public function test_orderByID_desc(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByID(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['id' => 'DESC']], $actual);
    }

    public function test_orderByDescription_noParam(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByDescription()
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['description' => 'ASC']], $actual);
    }

    public function test_orderByDescription_asc(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByDescription(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['description' => 'ASC']], $actual);
    }

    public function test_orderByDescription_desc(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByDescription(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['description' => 'DESC']], $actual);
    }

    public function test_orderByCount_noParam(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByCount()
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['count' => 'ASC']], $actual);
    }

    public function test_orderByCount_asc(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByCount(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['count' => 'ASC']], $actual);
    }

    public function test_orderByCount_desc(): void
    {
        $obj = new TermOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByCount(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([TermOrderByExpr::class => ['count' => 'DESC']], $actual);
    }
}

class TermOrderQuerableTestMockImpl
{
    use Querable, TermOrderQuerable;
}