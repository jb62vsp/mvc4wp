<?php

declare(strict_types=1);

namespace Mvc4Wp\Core\Model\Repository\User;

/**
 * @see https://developer.wordpress.org/reference/classes/wp_user_query/#user-role-parameter
 */
trait UserRoleQuerable
{
    /**
     * @param string $role Role name.
     */
    public function byRole(string $role): static
    {
        $new = clone $this;

        $new->setExpression(UserRoleExpr::class, $role);

        return $new;
    }
}
