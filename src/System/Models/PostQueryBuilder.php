<?php declare(strict_types=1);
namespace System\Models;

use WP_Query;

class PostQueryBuilder
{
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
            'post_type' => PostType::getPostType($this->class_name),
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
            array_push($post_types, PostType::getPostType($class));
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
                $data = get_post(get_the_ID());
                $obj->bind($data);
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
                $data = get_post(get_the_ID());
                $result->bind($data);
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