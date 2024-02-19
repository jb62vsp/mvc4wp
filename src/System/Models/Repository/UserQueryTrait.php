<?php declare(strict_types=1);
namespace System\Models\Repository;

use System\Models\Model;
use System\Models\UserModel;

trait UserQueryTrait
{
    protected array $queries = [];

    public function __construct(
        protected string $class_name
    ) {
        $this->initCriteria();
    }

    private function initCriteria(): void
    {
        $this->queries = [];
    }

    public function search(string $key, string $value, string $compare = '=', string $type = 'CHAR'): self
    {
        // TODO:
        return $this;
    }

    public function order(string $order_by, string $order = 'ASC', string $type = 'CHAR'): self
    {
        // TODO:
        return $this;
    }

    public function single(): self
    {
        // TODO:
        return $this;
    }

    public function all(): self
    {
        // TODO:
        return $this;
    }

    public function page(int $page, int $per_page): self
    {
        // TODO:
        return $this;
    }

    protected function build(): \WP_User_Query
    {
        return new \WP_User_Query($this->queries);
    }

    public function custom(array $criteria): self
    {
        $this->queries = $criteria;
        return $this;
    }

    /**
     * @return array<UserModel>
     */
    public function get(): array
    {
        $result = [];

        // TODO:

        return $result;
    }

    public function getSingle(): ?Model
    {
        $result = null;

        // TODO:

        return $result;
    }

    public function byID(int $id): ?Model
    {
        $result = null;

        $user = get_user_by('id', $id);
        if ($user) {
            $cls = $this->class_name;
            $result = new $cls();
            $result->bind($user->data, false);
            $user_meta = get_user_meta($id);
            $result->bind($user_meta, false);
        }

        return $result;
    }

    public function count(): int
    {
        $result = 0;

        // TODO:

        return $result;
    }
}