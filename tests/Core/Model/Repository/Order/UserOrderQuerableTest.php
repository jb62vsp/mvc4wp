<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Order;

use Mvc4Wp\Core\Model\Repository\OrderInQuery;
use Mvc4Wp\Core\Model\Repository\Querable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UserOrderQuerable::class)]
class UserOrderQuerableTest extends TestCase
{
    public function test_orderByDisplayName_noParam(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByDisplayName()
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['display_name' => ['ASC', '']]], $actual);
    }

    public function test_orderByDisplayName_asc(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByDisplayName(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['display_name' => ['ASC', '']]], $actual);
    }

    public function test_orderByDisplayName_desc(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByDisplayName(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['display_name' => ['DESC', '']]], $actual);
    }

    public function test_orderByLogin_noParam(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByLogin()
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['login' => ['ASC', '']]], $actual);
    }

    public function test_orderByLogin_asc(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByLogin(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['login' => ['ASC', '']]], $actual);
    }

    public function test_orderByLogin_desc(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByLogin(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['login' => ['DESC', '']]], $actual);
    }

    public function test_orderByNicename_noParam(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByNicename()
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['nicename' => ['ASC', '']]], $actual);
    }

    public function test_orderByNicename_asc(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByNicename(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['nicename' => ['ASC', '']]], $actual);
    }

    public function test_orderByNicename_desc(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByNicename(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['nicename' => ['DESC', '']]], $actual);
    }

    public function test_orderByEmail_noParam(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByEmail()
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['email' => ['ASC', '']]], $actual);
    }

    public function test_orderByEmail_asc(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByEmail(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['email' => ['ASC', '']]], $actual);
    }

    public function test_orderByEmail_desc(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByEmail(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['email' => ['DESC', '']]], $actual);
    }

    public function test_orderByUrl_noParam(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByUrl()
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['url' => ['ASC', '']]], $actual);
    }

    public function test_orderByUrl_asc(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByUrl(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['url' => ['ASC', '']]], $actual);
    }

    public function test_orderByUrl_desc(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByUrl(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['url' => ['DESC', '']]], $actual);
    }

    public function test_orderByRegistered_noParam(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByRegistered()
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['registered' => ['ASC', '']]], $actual);
    }

    public function test_orderByRegistered_asc(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByRegistered(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['registered' => ['ASC', '']]], $actual);
    }

    public function test_orderByRegistered_desc(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByRegistered(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['registered' => ['DESC', '']]], $actual);
    }

    public function test_orderByPostCount_noParam(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByPostCount()
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['post_count' => ['ASC', '']]], $actual);
    }

    public function test_orderByPostCount_asc(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByPostCount(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['post_count' => ['ASC', '']]], $actual);
    }

    public function test_orderByPostCount_desc(): void
    {
        $obj = new UserOrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByPostCount(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['post_count' => ['DESC', '']]], $actual);
    }
}

class UserOrderQuerableTestMockImpl
{
    use Querable, UserOrderQuerable;
}