<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\UserEntity;

class UserQueryExecutor implements QueryExecutorInterface
{
    use Castable;

    public function __construct(
        protected string $entity_class,
        protected array $queries,
    ) {
    }

    public function get(): array
    {
        $result = [];

        $users = $this->fetch();
        foreach ($users as $user) {
            $model = $this->bindByID($user->ID);
            $result[] = $model;
        }

        return $result;
    }

    public function getSingle(): UserEntity|null
    {
        $result = null;

        $users = $this->fetch();
        if (!empty($users)) {
            $result = $this->bindByID($users[0]);
        }

        return $result;
    }

    public function count(): int
    {
        $result = 0;

        $ids = $this->fetch();
        $result = count($ids);

        return $result;
    }

    protected function fetch(): array
    {
        $wp_query = new \WP_User_Query($this->queries);
        return $wp_query->get_results() ?: [];
    }

    protected function bindByID(int $id): UserEntity|null
    {
        $result = null;

        if ($id !== 0) {
            $user = get_user_by('id', $id);
            if ($user) {
                $cls = $this->entity_class;
                $result = new $cls();
                $result->bind($user->data, false);
                $user_meta = get_user_meta($id);
                $result->bind($user_meta, false);
            }
        }

        return $result;
    }
}