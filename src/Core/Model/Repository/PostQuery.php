<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Model;
use Mvc4Wp\Core\Model\Attribute\PostType;

/**
 * @template TModel of Model
 * @implements QueryInterface<TModel>
 */
class PostQuery implements QueryInterface
{
    use Castable;

    private const EMBEDDED_ORDER_COLUMNS = [
        'none' => 'none',
        'ID' => 'ID',
        'id' => 'ID',
        'post_author' => 'author',
        'post_title' => 'title',
        'post_name' => 'name',
        'post_type' => 'type',
        'post_date' => 'date',
        'modified' => 'modified',
        'parent' => 'parent',
        'rand' => 'rand',
        'comment_count' => 'comment_count',
        'relevance' => 'relevance',
        'menu_order' => 'menu_order',
        'meta_value' => 'meta_value',
        'meta_value_num' => 'meta_value_num',
        'post__in' => 'post__in',
        'post_name__in' => 'post_name__in',
        'post_parent__in' => 'post_parent__in',
    ];

    protected array $queries;

    public function __construct(
        protected string $class_name
    ) {
        $this->initCriteria();
    }

    // ---- criteria ----

    private function initCriteria(): void
    {
        $this->queries = [
            'fields' => 'ids',
            'post_status' => 'publish',
            'post_type' => PostType::getName($this->class_name),
        ];
    }

    private function addCriteria(string $key, string|array $value): void
    {
        if (array_key_exists($key, $this->queries) && is_array($this->queries[$key])) {
            array_push($this->queries[$key], $value);
        } elseif (array_key_exists($key, $this->queries)) {
            $exist = $this->queries[$key];
            $this->queries[$key] = [$exist, $value];
        } else {
            $this->queries[$key] = $value;
        }
    }

    public function asModel(array $classes): self
    {
        $new = clone $this;

        $post_types = [];
        foreach ($classes as $class) {
            array_push($post_types, PostType::getName($class));
        }
        $new->queries['post_type'] = $post_types;

        return $new;
    }

    // ---- post_status

    public function withDraft(): self
    {
        $new = clone $this;

        $new->addCriteria('post_status', 'draft');

        return $new;
    }

    public function withTrash(): self
    {
        $new = clone $this;

        $new->addCriteria('post_status', 'trash');

        return $new;
    }

    // ---- search

    /**
     * custom field only
     * @param string $key key
     * @param string $value value
     * @param string $compare Compare operator. "=", "!=", ">", ">=", "<", "<=", "LIKE", "NOT LIKE", "IN", "NOT IN", "BETWEEN", "NOT BETWEEN", "EXISTS", "NOT EXISTS", "REGEXP", "NOT REGEXP", "RLIKE". Default value is "=".
     * @param string $type Compare type. "NUMERIC", "BINARY", "CHAR", "DATE", "DATETIME", "DECIMAL", "SIGNED", "TIME", "UNSIGNED". Default value is "CHAR".
     */
    public function by(string $key, string $value, string $compare = '=', string $type = 'CHAR'): self
    {
        $new = clone $this;

        if (array_key_exists('meta_query', $new->queries)) {
            array_push($new->queries['meta_query'], [
                'key' => $key,
                'compare' => $compare,
                'value' => $value,
                'type' => $type,
            ]);
        } elseif (array_key_exists('meta_key', $new->queries)) {
            $exists = [];
            $exists['key'] = $new->queries['meta_key'];
            unset($new->queries['meta_key']);
            $exists['compare'] = $new->queries['meta_compare'];
            unset($new->queries['meta_compare']);
            $exists['value'] = $new->queries['meta_value'];
            unset($new->queries['meta_value']);
            $exists['type'] = $new->queries['meta_type'];
            unset($new->queries['meta_type']);

            $new->queries['meta_query'] = [
                'relation' => 'AND',
                $exists,
                [
                    'key' => $key,
                    'compare' => $compare,
                    'value' => $value,
                    'type' => $type,
                ]
            ];
        } else {
            $new->queries['meta_key'] = $key;
            $new->queries['meta_compare'] = $compare;
            $new->queries['meta_value'] = $value;
            $new->queries['meta_type'] = $type;
        }

        return $this;
    }

    // ---- sort

    /**
     * @param string $order_by Column name.
     * @param string $order "ASC", "DESC". Default value is "ASC"
     * @param string $type Compare type. "NUMERIC", "BINARY", "CHAR", "DATE", "DATETIME", "DECIMAL", "SIGNED", "TIME", "UNSIGNED". Default value is "CHAR".
     */
    public function order(string $order_by, string $order = 'ASC', string $type = 'CHAR'): self
    {
        $new = clone $this;

        if (array_key_exists($order_by, self::EMBEDDED_ORDER_COLUMNS)) {
            $new->queries['orderby'] = self::EMBEDDED_ORDER_COLUMNS[$order_by];
            $new->queries['order'] = $order;
        } else {
            $new->queries['orderby'] = 'meta_value';
            $new->queries['order'] = $order;
            $new->queries['meta_key'] = $order_by;
            $new->queries['meta_type'] = $type;
        }

        return $new;
    }

    // ---- pagination ----

    public function single(): self
    {
        $new = clone $this;

        if (array_key_exists('paged', $new->queries)) {
            unset($new->queries['paged']);
        }
        $new->queries['posts_per_page'] = -1;

        return $new;
    }

    public function all(): self
    {
        $new = clone $this;

        if (array_key_exists('paged', $new->queries)) {
            unset($new->queries['paged']);
        }
        $new->queries['posts_per_page'] = -1;

        return $new;
    }

    public function page(int $page, int $per_page): self
    {
        $new = clone $this;

        $new->queries['paged'] = $page;
        $new->queries['posts_per_page'] = $per_page;

        return $new;
    }

    // ---- execute ----

    public function raw(array $criteria): self
    {
        $new = clone $this;

        $new->queries = $criteria;

        return $new;
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

    public function getSingle(): ?Model
    {
        $result = null;

        $this->single();
        $ids = $this->fetch();
        if (!empty($ids)) {
            $result = $this->bindByID($ids[0]);
        }

        return $result;
    }

    public function byID(int $id): ?Model
    {
        $this->queries['p'] = $id;
        return $this->getSingle();
    }

    public function count(): int
    {
        $result = 0;

        $ids = $this->fetch();
        $result = count($ids);

        return $result;
    }

    private function fetch(): array
    {
        $wp_query = new \WP_Query($this->queries);
        return $wp_query->get_posts();
    }

    private function bindByID(int $id): Model
    {
        $cls = $this->class_name;
        $result = new $cls();

        $data = get_post($id);
        $result->bind($data, false);
        $meta = get_post_custom($id);
        $result->bind($meta, false);

        return $result;
    }
}