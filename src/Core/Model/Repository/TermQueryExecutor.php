<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\TermEntity;
use Mvc4Wp\Core\Service\Logging;

class TermQueryExecutor implements QueryExecutorInterface
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

        $terms = $this->fetch();
        foreach ($terms as $term) {
            $model = $this->bindByTerm($term);
            $result[] = $model;
        }

        debug_add_end('query', ['executor' => get_class($this), 'query' => $this->query]);

        return $result;
    }

    public function single(): TermEntity|null
    {
        $result = null;

        debug_add_start();

        $ids = $this->fetch();
        if (!empty($ids)) {
            $result = $this->bindByTerm($ids[0]);
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
        $result = get_terms($this->query);
        return $result;
    }

    protected function bindByTerm(object $term): TermEntity
    {
        $result = new $this->entity_class();

        $result->bind($term);
        $data = get_term_meta($result->term_id);
        $result->bind($data);

        return $result;
    }
}