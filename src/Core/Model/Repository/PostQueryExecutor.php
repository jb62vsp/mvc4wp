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

        debug_add_start();

        $ids = $this->fetch();
        foreach ($ids as $id) {
            $model = $this->bindByID($id);
            $result[] = $model;
        }

        debug_add_end('query', ['executor' => get_class($this), 'query' => $this->query]);

        return $result;
    }

    public function single(): PostEntity|null
    {
        $result = null;

        debug_add_start();

        $ids = $this->fetch();
        if (!empty($ids)) {
            $result = $this->bindByID($ids[0]);
        }

        debug_add_end('query', ['executor' => get_class($this), 'query' => $this->query]);

        return $result;
    }

    public function count(): int
    {
        $result = 0;

        debug_add_start();

        $results = $this->fetch();
        if (is_array($results)) {
            $result = count($results);
        }

        debug_add_end('query', ['executor' => get_class($this), 'query' => $this->query]);

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