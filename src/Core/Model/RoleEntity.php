<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Repository\RoleQueryBuilder;

class RoleEntity extends Entity
{
    use Castable;

    public string $role;

    public string $display_name;

    /**
     * @var array<Capability>
     */
    public array $capabilities;

    public static function find(): RoleQueryBuilder
    {
        $result = new RoleQueryBuilder(static::class);
        return $result;
    }

    /**
     * @return array<static>
     */
    public static function findAll(): array
    {
        $result = static::find()
            ->build()
            ->list();

        return $result;
    }

    /**
     * @param string $role
     * @return static|null
     */
    public static function findByRole(string $role): static|null
    {
        $result = static::find()
            ->byRole($role)
            ->build()
            ->single();

        return $result;
    }

    public function register(): int
    {
        add_role(
            $this->role,
            $this->display_name,
            array_fill_keys(array_map(fn($c) => $c->value, $this->capabilities), true)
        );

        return -1;
    }

    public function update(): void
    {
        $this->delete();
        $this->register();
    }

    public function delete(bool $force_delete = false): bool
    {
        remove_role($this->role);

        return true;
    }

    /**
     * @return bool
     */
    public function hasCapability(Capability $capability): bool
    {
        foreach ($this->capabilities as $target) {
            if ($target === $capability) {
                return true;
            }
        }
        return false;
    }
}