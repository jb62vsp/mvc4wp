<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\User;

use Mvc4Wp\Core\Model\Repository\Querable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UserQuerable::class)]
class UserQuerableTest extends TestCase
{
    public function test_byID_single(): void
    {
        $obj = new UserQuerableTestMockImpl();

        $actual = $obj
            ->byID(1)
            ->getExpressions();
        $this->assertEquals([
            UserSearchExpr::class => [
                1,
                ['ID'],
            ]
        ], $actual);
    }

    public function test_byID_chain(): void
    {
        $obj = new UserQuerableTestMockImpl();

        $actual = $obj
            ->byID(1)
            ->byID(2)
            ->byID(3)
            ->getExpressions();
        $this->assertEquals([
            UserSearchExpr::class => [
                3,
                ['ID'],
            ]
        ], $actual);
    }

    public function test_byLogin_single(): void
    {
        $obj = new UserQuerableTestMockImpl();

        $actual = $obj
            ->byLogin('hoge')
            ->getExpressions();
        $this->assertEquals([
            UserSearchExpr::class => [
                '*hoge*',
                ['user_login'],
            ]
        ], $actual);
    }

    public function test_byLogin_singleWithExact(): void
    {
        $obj = new UserQuerableTestMockImpl();

        $actual = $obj
            ->byLogin('hoge', true)
            ->getExpressions();
        $this->assertEquals([
            UserSearchExpr::class => [
                'hoge',
                ['user_login'],
            ]
        ], $actual);
    }

    public function test_byLogin_chain(): void
    {
        $obj = new UserQuerableTestMockImpl();

        $actual = $obj
            ->byLogin('hoge')
            ->byLogin('fuga', true)
            ->byLogin('piyo')
            ->getExpressions();
        $this->assertEquals([
            UserSearchExpr::class => [
                '*piyo*',
                ['user_login'],
            ]
        ], $actual);
    }
    
    public function test_byNicename_single(): void
    {
        $obj = new UserQuerableTestMockImpl();

        $actual = $obj
            ->byNicename('hoge')
            ->getExpressions();
        $this->assertEquals([
            UserSearchExpr::class => [
                '*hoge*',
                ['user_nicename'],
            ]
        ], $actual);
    }

    public function test_byNicename_singleWithExact(): void
    {
        $obj = new UserQuerableTestMockImpl();

        $actual = $obj
            ->byNicename('hoge', true)
            ->getExpressions();
        $this->assertEquals([
            UserSearchExpr::class => [
                'hoge',
                ['user_nicename'],
            ]
        ], $actual);
    }

    public function test_byNicename_chain(): void
    {
        $obj = new UserQuerableTestMockImpl();

        $actual = $obj
            ->byNicename('hoge')
            ->byNicename('fuga', true)
            ->byNicename('piyo')
            ->getExpressions();
        $this->assertEquals([
            UserSearchExpr::class => [
                '*piyo*',
                ['user_nicename'],
            ]
        ], $actual);
    }

    public function test_byEmail_single(): void
    {
        $obj = new UserQuerableTestMockImpl();

        $actual = $obj
            ->byEmail('hoge')
            ->getExpressions();
        $this->assertEquals([
            UserSearchExpr::class => [
                '*hoge*',
                ['user_email'],
            ]
        ], $actual);
    }

    public function test_byEmail_singleWithExact(): void
    {
        $obj = new UserQuerableTestMockImpl();

        $actual = $obj
            ->byEmail('hoge', true)
            ->getExpressions();
        $this->assertEquals([
            UserSearchExpr::class => [
                'hoge',
                ['user_email'],
            ]
        ], $actual);
    }

    public function test_byEmail_chain(): void
    {
        $obj = new UserQuerableTestMockImpl();

        $actual = $obj
            ->byEmail('hoge')
            ->byEmail('fuga', true)
            ->byEmail('piyo')
            ->getExpressions();
        $this->assertEquals([
            UserSearchExpr::class => [
                '*piyo*',
                ['user_email'],
            ]
        ], $actual);
    }

    public function test_byUrl_single(): void
    {
        $obj = new UserQuerableTestMockImpl();

        $actual = $obj
            ->byUrl('hoge')
            ->getExpressions();
        $this->assertEquals([
            UserSearchExpr::class => [
                '*hoge*',
                ['user_url'],
            ]
        ], $actual);
    }

    public function test_byUrl_singleWithExact(): void
    {
        $obj = new UserQuerableTestMockImpl();

        $actual = $obj
            ->byUrl('hoge', true)
            ->getExpressions();
        $this->assertEquals([
            UserSearchExpr::class => [
                'hoge',
                ['user_url'],
            ]
        ], $actual);
    }

    public function test_byUrl_chain(): void
    {
        $obj = new UserQuerableTestMockImpl();

        $actual = $obj
            ->byUrl('hoge')
            ->byUrl('fuga', true)
            ->byUrl('piyo')
            ->getExpressions();
        $this->assertEquals([
            UserSearchExpr::class => [
                '*piyo*',
                ['user_url'],
            ]
        ], $actual);
    }

    public function test_search_single(): void
    {
        $obj = new UserQuerableTestMockImpl();

        $actual = $obj
            ->search('hoge')
            ->getExpressions();
        $this->assertEquals([
            UserSearchExpr::class => [
                '*hoge*',
                [
                    'ID',
                    'user_login',
                    'user_nicename',
                    'user_email',
                    'user_url',
                ],
            ]
        ], $actual);
    }

    public function test_search_chain(): void
    {
        $obj = new UserQuerableTestMockImpl();

        $actual = $obj
            ->search('hoge')
            ->search('fuga')
            ->search('piyo')
            ->getExpressions();
        $this->assertEquals([
            UserSearchExpr::class => [
                '*piyo*',
                [
                    'ID',
                    'user_login',
                    'user_nicename',
                    'user_email',
                    'user_url',
                ],
            ]
        ], $actual);
    }
}

class UserQuerableTestMockImpl
{
    use Querable, UserQuerable;
}