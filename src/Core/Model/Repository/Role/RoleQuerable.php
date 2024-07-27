<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Role;

/**
 * @see https://developer.wordpress.org/reference/functions/get_role/
 */
trait RoleQuerable
{
    /**
     * @param string $role Role name.
     */
    public function byRole(string $role): static
    {
        $new = clone $this;

        $new->setExpression(RoleExpr::class, $role);

        return $new;
    }
}