<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\CustomField;

use Mvc4Wp\Core\Model\Repository\CustomField\CustomFieldExpr;
use Mvc4Wp\Core\Model\Repository\Querable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CustomFieldQuerable::class)]
class CustomFieldQuerableTest extends TestCase
{
    public function test_by_single(): void
    {
        $obj = new CustomFieldQuerableTestMockImpl();

        $actual = $obj
            ->by('hoge', 'HOGE', '=', 'CHAR')
            ->getExpressions();
        $this->assertEquals([
            CustomFieldExpr::class => [
                ['hoge', 'HOGE', '=', 'CHAR'],
            ],
        ], $actual);
    }

    public function test_by_chain(): void
    {
        $obj = new CustomFieldQuerableTestMockImpl();

        $actual = $obj
            ->by('hoge', 'HOGE', '=', 'CHAR')
            ->by('fuga', 1, '<', 'NUMERIC')
            ->getExpressions();
        $this->assertEquals([
            CustomFieldExpr::class => [
                ['hoge', 'HOGE', '=', 'CHAR'],
                ['fuga', 1, '<', 'NUMERIC'],
            ],
        ], $actual);
    }
}

class CustomFieldQuerableTestMockImpl
{
    use Querable, CustomFieldQuerable;
}