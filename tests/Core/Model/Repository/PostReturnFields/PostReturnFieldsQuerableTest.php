<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostReturnFields;

use Mvc4Wp\Core\Model\Repository\Querable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostReturnFieldsQuerable::class)]
class PostReturnFieldsQuerableTest extends TestCase
{
    public function test_fetchAll_single(): void
    {
        $obj = new PostReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->_fetchAll()
            ->getExpressions();
        $this->assertEquals([PostReturnFieldsExpr::class => ['all']], $actual);
    }

    public function test_fetchAll_chain(): void
    {
        $obj = new PostReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->_fetchAll()
            ->_fetchAll()
            ->getExpressions();
        $this->assertCount(1, $actual);
        $this->assertEquals([PostReturnFieldsExpr::class => ['all']], $actual);
    }

    public function test_fetchOnlyID_single(): void
    {
        $obj = new PostReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->_fetchOnlyID()
            ->getExpressions();
        $this->assertEquals([PostReturnFieldsExpr::class => ['ids']], $actual);
    }

    public function test_fetchOnlyID_chain(): void
    {
        $obj = new PostReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->_fetchOnlyID()
            ->_fetchOnlyID()
            ->getExpressions();
        $this->assertEquals([PostReturnFieldsExpr::class => ['ids']], $actual);
    }

    public function test_parent_single(): void
    {
        $obj = new PostReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->_parent()
            ->getExpressions();
        $this->assertEquals([PostReturnFieldsExpr::class => ['id=>parent']], $actual);
    }

    public function test_parent_chain(): void
    {
        $obj = new PostReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->_parent()
            ->_parent()
            ->getExpressions();
        $this->assertEquals([PostReturnFieldsExpr::class => ['id=>parent']], $actual);
    }

    public function test_chain(): void
    {
        $obj = new PostReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->_fetchAll()
            ->_fetchOnlyID()
            ->_parent()
            ->getExpressions();
        $this->assertEquals([PostReturnFieldsExpr::class => ['id=>parent']], $actual);
    }
}

class PostReturnFieldsQuerableTestMockImpl
{
    use Querable, PostReturnFieldsQuerable;

    public function _fetchAll(): static
    {
        return $this->fetchAll();
    }

    public function _fetchOnlyID(): static
    {
        return $this->fetchOnlyID();
    }

    public function _parent(): static
    {
        return $this->parent();
    }
}