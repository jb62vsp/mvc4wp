<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Capability;
use Mvc4Wp\Core\Model\RoleEntity;

class RoleQueryExecutor implements QueryExecutorInterface
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

        debug_add_start();

        // WP_Roles::__construct( int $site_id = null )
        $roles = new \WP_Roles();
        foreach ($roles->roles as $k => $v) {
            $entity = new RoleEntity();
            $entity->role = $k;
            $entity->display_name = $v['name'];
            foreach ($v['capabilities'] as $capability => $enabled) {
                if ($enabled && Capability::tryFrom($capability)) {
                    $entity->capabilities[] = Capability::from($capability);
                }
            }

            $result[] = $entity;
        }

        debug_add_end('query', ['executor' => get_class($this) . '::list', 'query' => $this->query]);

        return $result;
    }

    public function single(): RoleEntity|null
    {
        $result = null;

        debug_add_start();

        foreach ($this->list() as $role) {
            if (array_key_exists('role', $this->query) && $role->role === $this->query['role']) {
                $result = $role;
            }
        }

        debug_add_end('query', ['executor' => get_class($this) . '::single', 'query' => $this->query]);

        return $result;
    }

    public function count(): int
    {
        $result = 0;

        debug_add_start();

        if (array_key_exists('role', $this->query)) {
            $role = $this->single();
            $result = is_null($role) ? 0 : 1;
        } else {
            $roles = $this->list();
            $result = count($roles);
        }

        debug_add_end('query', ['executor' => get_class($this) . '::count', 'query' => $this->query]);

        return $result;
    }
}