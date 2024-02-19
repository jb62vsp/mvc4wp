<?php declare(strict_types=1);
namespace Mvc4Wp\System\Models;

use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Models\Repository\QueryInterface;
use Mvc4Wp\System\Models\Repository\UserQuery;

/**
 * @template TModel of UserEntity
 * @extends Model<TModel>
 */
#[Entity]
abstract class UserEntity extends Model
{
    use Cast;

    #[Bindable]
    public string $user_login;

    #[Bindable]
    public string $user_email;

    #[Bindable]
    public string $display_name;

    #[Bindable]
    public string $last_name;

    #[Bindable]
    public string $first_name;

    // public array $roles;

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