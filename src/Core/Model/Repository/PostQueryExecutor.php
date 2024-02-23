<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\PostEntity;

class PostQueryExecutor implements QueryExecutorInterface
{
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

    public function getSingle(): PostEntity|null
    {
        $result = null;

        $ids = $this->fetch();
        if (!empty($ids)) {
            $result = $this->bindByID($ids[0]);
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
        $wp_query = new \WP_Query($this->queries);
        return $wp_query->get_posts();
    }

    protected function bindByID(int $id): PostEntity
    {
        $cls = $this->entity_class;
        $result = new $cls();

        $data = get_post($id);
        $result->bind($data, false);
        $meta = get_post_custom($id);
        $result->bind($meta, false);

        return $result;
    }
}