<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Repository\QueryInterface;
use Mvc4Wp\Core\Model\Repository\UserQuery;

/**
 * @template TModel of UserModel
 * @extends UserEntity<TModel>
 */
#[Entity]
class UserModel extends UserEntity
{
    use Castable;

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
        $data = static::toArrayOnlyField($this);
        // wp_insert_user( array|object|WP_User $userdata ): int|WP_Error
        $id = wp_insert_user($data);
        $user = get_user_by('id', $id);
        $this->bind($user);

        return $id;
    }

    public function update(): void
    {
        $data = static::toArrayOnlyField($this);
        // wp_update_user( array|object|WP_User $userdata ): int|WP_Error
        wp_update_user($data);
        foreach ($data as $k => $v) {
            // update_user_meta( int $user_id, string $meta_key, mixed $meta_value, mixed $prev_value = ” ): int|bool
            update_user_meta($this->ID, $k, $v);
        }

    }

    public function delete(bool $force_delete = false): bool
    {
        // wp_delete_user( int $id, int $reassign = null ): bool
        require_once(ABSPATH . 'wp-admin/includes/user.php');
        $result = wp_delete_user($this->ID);
        return $result;
    }
}