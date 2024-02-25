<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\UserEntity;

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

        $users = $this->fetch();
        foreach ($users as $user) {
            $model = $this->bindByID($user->ID);
            $result[] = $model;
        }

        return $result;
    }

    public function single(): UserEntity|null
    {
        $result = null;

        $users = $this->fetch();
        if (!empty($users)) {
            $result = $this->bindByID($users[0]->ID);
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

    public function current(): ?UserEntity
    {
        $result = null;

        $id = get_current_user_id();
        $result = $this->bindByID($id);

        return $result;
    }

    protected function fetch(): array
    {
        $wp_query = new \WP_User_Query($this->query);
        return $wp_query->get_results() ?: [];
    }

    protected function bindByID(int $id): UserEntity|null
    {
        $result = null;

        if ($id !== 0) {
            $user = get_user_by('id', $id);
            if ($user) {
                $result = new $this->entity_class();
                $result->bind($user->data, false);
                $user_meta = get_user_meta($id);
                $result->bind($user_meta, false);
            }
        }

        return $result;
    }
}