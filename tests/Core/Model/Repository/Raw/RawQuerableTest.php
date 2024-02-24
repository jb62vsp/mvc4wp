<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Raw;

use Mvc4Wp\Core\Model\Repository\Querable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RawQuerable::class)]
class RawQuerableTest extends TestCase
{
    public function test_rawQuery_empty(): void
    {
        $obj = new RawQuerableTestMockImpl();

        $actual = $obj
            ->rawQuery([])
            ->getExpressions();
        $this->assertEquals([RawExpr::class => []], $actual);
    }

    public function test_rawQuery_single(): void
    {
        $obj = new RawQuerableTestMockImpl();

        $actual = $obj
            ->rawQuery(['hoge' => 'HOGE'])
            ->getExpressions();
        $this->assertEquals([RawExpr::class => ['hoge' => 'HOGE']], $actual);
    }

    public function test_rawQuery_multi(): void
    {
        $obj = new RawQuerableTestMockImpl();

        $actual = $obj
            ->rawQuery([
                'hoge' => 'HOGE',
                'fuga' => 'FUGA',
                'piyo' => 'PIYO',
            ])
            ->getExpressions();
        $this->assertEquals([
            RawExpr::class => [
                'hoge' => 'HOGE',
                'fuga' => 'FUGA',
                'piyo' => 'PIYO',
            ]
        ], $actual);
    }

    public function test_rawQuery_chain(): void
    {
        $obj = new RawQuerableTestMockImpl();

        $actual = $obj
            ->rawQuery(['hoge'])
            ->rawQuery(['fuga'])
            ->getExpressions();
        $this->assertCount(1, $actual);
        $this->assertEquals([RawExpr::class => ['fuga']], $actual);
    }
}

class RawQuerableTestMockImpl
{
    use Querable, RawQuerable;
}