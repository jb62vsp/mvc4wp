<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\PostEntity;
use Mvc4Wp\Core\Service\Logging;

class PostQueryExecutor implements QueryExecutorInterface
{
    public function __construct(
        protected string $entity_class,
        protected array $query,
    ) {
    }

    public function list(): array
    {
        $result = [];

        $ids = $this->fetch();
        foreach ($ids as $id) {
            $model = $this->bindByID($id);
            $result[] = $model;
        }

        return $result;
    }

    public function single(): PostEntity|null
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

        $results = $this->fetch();
        if (is_array($results)) {
            $result = count($results);
        }

        return $result;
    }

    protected function fetch(): array
    {
        Logging::get('core')->debug('execute query', $this->query);
        $wp_query = new \WP_Query($this->query);
        return $wp_query->get_posts();
    }

    protected function bindByID(int $id): PostEntity
    {
        $result = new $this->entity_class();

        $data = get_post($id);
        $result->bind($data, false);
        $meta = get_post_custom($id);
        $result->bind($meta, false);

        return $result;
    }
}