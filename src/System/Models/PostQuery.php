<?php declare(strict_types=1);
namespace System\Models;

use System\Core\Cast;
use WP_Query;

class PostQuery
{
    use Cast;

    protected array $queries = [];

    public function __construct(
        protected string $class_name
    ) {
        $this->initCriteria();
    }

    // ---- criteria ----

    private function initCriteria(): void
    {
        $this->queries = [
            'post_type' => PostType::getName($this->class_name),
        ];
    }

    private function addCriteria(string $key, string $value): bool
    {
        if (array_key_exists($key, $this->queries)) {
            if (is_array($this->queries[$key])) {
                array_push($this->queries[$key], $value);
            } else {
                $exist = $this->queries[$key];
                $this->queries[$key] = [$exist, $value];
            }
            return true;
        }
        return false;
    }

    public function postType(array $classes): self
    {
        $post_types = [];
        foreach ($classes as $class) {
            array_push($post_types, PostType::getName($class));
        }
        $this->queries['post_type'] = $post_types;
        return $this;
    }

    // ---- post_status

    public function withDraft(): self
    {

        if (!$this->addCriteria('post_status', 'draft')) {
            $this->queries['post_status'] = ['publish', 'draft'];
        }
        return $this;
    }

    public function withTrash(): self
    {
        if (!$this->addCriteria('post_status', 'trash')) {
            $this->queries['post_status'] = ['publish', 'trash'];
        }
        return $this;
    }

    // ---- search

    /**
     * custom field only
     * @param string $key key
     * @param string $value value
     * @param string $compare Compare operator. =, !=, >, >=, <, <=, LIKE, NOT LIKE, IN, NOT IN, BETWEEN, NOT BETWEEN, EXISTS, NOT EXISTS, REGEXP, NOT REGEXP, RLIKE. Default value is =.
     * @param string $type Compare type. NUMERIC, BINARY, CHAR, DATE, DATETIME, DECIMAL, SIGNED, TIME, UNSIGNED. Default value is CHAR.
     */
    public function search(string $key, string $value, string $compare = '=', string $type = 'CHAR'): self
    {
        if (array_key_exists('meta_query', $this->queries)) {
            array_push($this->queries['meta_query'], [
                'key' => $key,
                'compare' => $compare,
                'value' => $value,
                'type' => $type,
            ]);
        } elseif (array_key_exists('meta_key', $this->queries)) {
            $exists = [];
            $exists['key'] = $this->queries['meta_key'];
            unset($this->queries['meta_key']);
            $exists['compare'] = $this->queries['meta_compare'];
            unset($this->queries['meta_compare']);
            $exists['value'] = $this->queries['meta_value'];
            unset($this->queries['meta_value']);
            $exists['type'] = $this->queries['meta_type'];
            unset($this->queries['meta_type']);

            $this->queries['meta_query'] = [
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
            $this->queries['meta_key'] = $key;
            $this->queries['meta_compare'] = $compare;
            $this->queries['meta_value'] = $value;
            $this->queries['meta_type'] = $type;
        }
        return $this;
    }

    // ---- sort

    public function order(string $order_by, $order): self
    {
        $this->queries['orderby'] = $order_by;
        $this->queries['order'] = $order;
        return $this;
    }

    public function orderMeta(string $order_by, $order): self
    {
        $this->queries['meta_key'] = $order_by;
        $this->queries['orderby'] = 'meta_value';
        $this->queries['order'] = $order;
        return $this;
    }

    // ---- execute ----

    protected function build(): WP_Query
    {
        return new WP_Query($this->queries);
    }

    public function custom(array $criteria): self
    {
        $this->queries = $criteria;
        return $this;
    }

    public function get(): array
    {
        $result = [];

        $query = $this->build();
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $cls = $this->class_name;
                $obj = new $cls();
                $id = get_the_ID();
                $data = get_post($id);
                $obj->bind($data, false);
                $meta = get_post_custom($id);
                $obj->bind($meta, false);
                array_push($result, $obj);
            }
        }
        wp_reset_postdata();

        return $result;
    }

    public function getSingle(): ?Model
    {
        $result = null;

        $query = $this->build();
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $cls = $this->class_name;
                $result = new $cls();
                $id = get_the_ID();
                $data = get_post($id);
                $result->bind($data, false);
                $meta = get_post_custom($id);
                $result->bind($meta, false);
                break;
            }
        }
        wp_reset_postdata();

        return $result;
    }

    public function byID(int $id): ?Model
    {
        $this->queries['p'] = $id;
        return $this->getSingle();
    }
}