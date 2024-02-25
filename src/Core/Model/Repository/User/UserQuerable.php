<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\User;

/**
 * @see https://developer.wordpress.org/reference/classes/wp_user_query/#search-parameters
 */
trait UserQuerable
{
    /**
     * @param int $id User ID.
     */
    public function byID(int $id): static
    {
        $new = clone $this;

        $new->setExpression(UserSearchExpr::class, [$id, [UserSearchExpr::ID]]);

        return $new;
    }

    /**
     * @param string $login User login.
     * @param bool $exect is exact match.
     * Default is false.
     */
    public function byLogin(string $login, bool $exact = false): static
    {
        $new = clone $this;

        if (!$exact) {
            $login = "*{$login}*";
        }
        $new->setExpression(UserSearchExpr::class, [$login, [UserSearchExpr::USER_LOGIN]]);

        return $new;
    }

    /**
     * @param string $nicename User nicename.
     * @param bool $exect is exact match.
     * Default is false.
     */
    public function byNicename(string $nicename, bool $exact = false): static
    {
        $new = clone $this;

        if (!$exact) {
            $nicename = "*{$nicename}*";
        }
        $new->setExpression(UserSearchExpr::class, [$nicename, [UserSearchExpr::USER_NICENAME]]);

        return $new;
    }

    /**
     * @param string $email User email.
     * @param bool $exect is exact match.
     * Default is false.
     */
    public function byEmail(string $email, bool $exact = false): static
    {
        $new = clone $this;

        if (!$exact) {
            $email = "*{$email}*";
        }
        $new->setExpression(UserSearchExpr::class, [$email, [UserSearchExpr::USER_EMAIL]]);

        return $new;
    }

    /**
     * @param string $url User URL.
     * @param bool $exect is exact match.
     * Default is false.
     */
    public function byUrl(string $url, bool $exact = false): static
    {
        $new = clone $this;

        if (!$exact) {
            $url = "*{$url}*";
        }
        $new->setExpression(UserSearchExpr::class, [$url, [UserSearchExpr::USER_URL]]);

        return $new;
    }

    /**
     * @param string $keyword Search keyword.
     */
    public function search(string $keyword): static
    {
        $new = clone $this;

        $new->setExpression(UserSearchExpr::class, [
            "*{$keyword}*",
            [
                UserSearchExpr::ID,
                UserSearchExpr::USER_LOGIN,
                UserSearchExpr::USER_NICENAME,
                UserSearchExpr::USER_EMAIL,
                UserSearchExpr::USER_URL,
            ]
        ]);

        return $new;
    }
}