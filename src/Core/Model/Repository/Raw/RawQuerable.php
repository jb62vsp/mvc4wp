<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Raw;

use Mvc4Wp\Core\Library\Castable;

trait RawQuerable
{
    use Castable;

    /**
     * @param array<string, string|int> $query raw query types ['key' => 'value',].
     */
    public function rawQuery(array $query): static
    {
        $new = clone $this;

        $new->setExpression(RawExpr::class, $query);

        return $new;
    }
}