<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\Entry;
use Mvc4Wp\Core\Model\Repository\TermQueryBuilder;

#[Entry(name: 'post_tag')]
class TagEntity extends TermEntity
{
    use Castable;

    public static function find(): TermQueryBuilder
    {
        $result = new TermQueryBuilder(static::class);
        return $result;
    }

    public static function findBySlug(string $slug): TagEntity
    {
        return static::find()
            ->bySlug($slug)
            ->showEmpty()
            ->build()
            ->single()
        ;
    }

    public function register(bool $publish = true): int
    {
        return $this->term_id;
    }

    public function update(): void
    {

    }

    public function delete(bool $force_delete = false): bool
    {
        return true;
    }
}