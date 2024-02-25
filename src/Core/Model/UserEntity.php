<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\Field;
use Mvc4Wp\Core\Model\Repository\UserQueryBuilder;

class UserEntity extends Entity
{
    use Castable;

    #[Field]
    public string $user_login;

    #[Field]
    public string $user_email;

    #[Field]
    public string $display_name;

    #[Field]
    public string $last_name;

    #[Field]
    public string $first_name;

    public static function find(): UserQueryBuilder
    {
        $result = new UserQueryBuilder(static::class);
        return $result;
    }

    public static function findByID(int $id): UserEntity|null
    {
        $result = static::find()
            ->byID($id)
            ->build()
            ->single();

        return $result;
    }

    public static function current(): UserEntity|null
    {
        $result = static::find()
            ->build()
            ->current();

        return $result;
    }

    public function register(): int
    {
        $data = static::toArrayOnlyField($this);
        // wp_insert_user( array|object|WP_User $userdata ): int|WP_Error
        $id = wp_insert_user($data);
        // get_user_by( string $field, int|string $value ): WP_User|false
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
        require_once(ABSPATH . 'wp-admin/includes/user.php');
        // wp_delete_user( int $id, int $reassign = null ): bool
        $result = wp_delete_user($this->ID);
        return $result;
    }
}