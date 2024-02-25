<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\User;

use Mvc4Wp\Core\Exception\QueryBuildViolationException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UserSearchExpr::class)]
class UserSearchExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new UserSearchExpr();

        $actual = $obj->toQuery([], ['hoge' => 'HOGE']);
        $this->assertEquals(['hoge' => 'HOGE'], $actual);
    }

    public function test_toQuery_singleParam(): void
    {
        $obj = new UserSearchExpr();

        $actual = $obj->toQuery([
            'hoge',
            ['ID'],
        ], []);
        $this->assertEquals([
            'search' => 'hoge',
            'search_columns' => ['ID']
        ], $actual);
    }

    public function test_toQuery_multiParams(): void
    {
        $obj = new UserSearchExpr();

        $actual = $obj->toQuery([
            'hoge',
            [
                'ID',
                'user_login',
                'user_nicename',
                'user_email',
                'user_url',
            ],
            'fuga',
            ['user_login'],
            'piyo',
            ['ID'],
        ], []);
        $this->assertEquals([
            'search' => 'hoge',
            'search_columns' => [
                'ID',
                'user_login',
                'user_nicename',
                'user_email',
                'user_url',
            ]
        ], $actual);
    }

    public function test_toQuery_oneTuple(): void
    {
        $this->expectException(QueryBuildViolationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('search_columns');
        $obj = new UserSearchExpr();
        $obj->toQuery([
            'hoge',
        ], []);
    }
}