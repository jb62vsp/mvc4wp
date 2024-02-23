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

        $ids = $this->fetch();
        foreach ($ids as $id) {
            $model = $this->bindByID($id);
            array_push($result, $model);
        }

        return $result;
    }

    public function getSingle(): ?UserEntity
    {
        $result = null;

        $ids = $this->fetch();
        if (!empty($ids)) {
            $result = $this->bindByID($ids[0]);
        }

        return $result;
    }

    public function byID(int $id): ?UserEntity
    {
        return $this->bindByID($id);
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
        return $wp_query->get_results();
    }

    protected function bindByID(int $id): ?UserEntity
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