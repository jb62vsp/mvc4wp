<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Post;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostPageIDExpr::class)]
class PostPageIDExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new PostPageIDExpr();

        $actual = $obj->toQuery([], ['hoge' => 'HOGE']);
        $this->assertEquals(['hoge' => 'HOGE'], $actual);
    }

    public function test_toQuery_singleParam(): void
    {
        $obj = new PostPageIDExpr();

        $actual = $obj->toQuery([1], []);
        $this->assertEquals(['page_id' => 1], $actual);
    }

    public function test_toQuery_multiParams(): void
    {
        $obj = new PostPageIDExpr();

        $actual = $obj->toQuery([1, 2, 3], []);
        $this->assertEquals(['page_id' => 1], $actual);
    }
}