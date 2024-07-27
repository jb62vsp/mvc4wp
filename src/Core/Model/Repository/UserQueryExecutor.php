<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\RoleEntity;
use Mvc4Wp\Core\Model\UserEntity;
use Mvc4Wp\Core\Service\Logging;

class UserQueryExecutor implements QueryExecutorInterface
{
    use Castable;

    public function __construct(
        protected string $entity_class,
        protected array $query,
    ) {
    }

    public function list(): array
    {
        $result = [];

        debug_add_start();

        $users = $this->fetch();
        foreach ($users as $user) {
            $model = $this->bindByID($user->ID);
            $result[] = $model;
        }

        debug_add_end('query', ['executor' => get_class($this) . '::list', 'query' => $this->query]);

        return $result;
    }

    public function single(): UserEntity|null
    {
        $result = null;

        debug_add_start();

        $users = $this->fetch();
        if (!empty($users)) {
            $result = $this->bindByID($users[0]->ID);
        }

        debug_add_end('query', ['executor' => get_class($this) . '::single', 'query' => $this->query]);

        return $result;
    }

    public function count(): int
    {
        $result = 0;

        debug_add_start();

        $ids = $this->fetch();
        $result = count($ids);

        debug_add_end('query', ['executor' => get_class($this) . '::count', 'query' => $this->query]);

        return $result;
    }

    public function current(): UserEntity|null
    {
        $result = null;

        debug_add_start();

        // get_current_user_id(): int
        $id = get_current_user_id();
        if ($id !== 0) {
            $result = $this->bindByID($id);
        }

        debug_add_end('query', ['executor' => get_class($this) . '::current', 'query' => 'current']);

        return $result;
    }

    protected function fetch(): array
    {
        Logging::get('core')->debug('execute query', $this->query);
        // https://developer.wordpress.org/reference/classes/wp_user_query/
        $wp_query = new \WP_User_Query($this->query);
        return $wp_query->get_results() ?: [];
    }

    protected function bindByID(int $id): UserEntity|null
    {
        $result = null;

        if ($id !== 0) {
            // get_user_by( string $field, int|string $value ): WP_User|false
            $user = get_user_by('id', $id);
            if ($user) {
                $result = new $this->entity_class();
                $result->bind($user->data);
                foreach ($user->roles as $role) {
                    $role_entity = RoleEntity::findByRole($role);
                    if (!is_null($role_entity)) {
                        $result->role = $role_entity;
                    }
                }
                // get_user_meta( int $user_id, string $key = ”, bool $single = false ): mixed
                $user_meta = get_user_meta($id);
                $result->bind($user_meta);
            }
        }

        return $result;
    }
}