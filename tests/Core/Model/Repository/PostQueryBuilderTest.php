<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\PostEntity;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostQueryBuilder::class)]
class PostQueryBuilderTest extends TestCase
{
    public function test_new(): void
    {
        $obj = new PostQueryBuilder(PostEntity::class);
        $this->assertNotNull($obj);
    }
}