<?php declare(strict_types=1);
namespace System\Models;

use System\Core\Cast;
use System\Models\Repository\QueryInterface;
use System\Models\Repository\UserQuery;

/**
 * @template TModel of UserModel
 * @extends UserEntity<TModel>
 */
#[Entity]
class UserModel extends UserEntity
{
    use Cast;

    /**
     * @return UserQuery<TModel>
     */
    public static function find(): QueryInterface
    {
        /** @var UserQuery<TModel> */
        $result = new UserQuery(static::class);
        return $result;
    }

    public function register(): int
    {
        return -1; // TODO:
    }

    public function update(): void
    {
        // TODO:
    }

    public function delete(bool $force_delete = false): bool
    {
        return false;
    }
}