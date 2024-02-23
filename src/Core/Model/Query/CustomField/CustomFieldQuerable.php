<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\CustomField;

use Mvc4Wp\Core\Model\Model;

/**
 * @template TModel of Model
 */
trait CustomFieldQuerable
{
    public function by(string $field, string|int|array $value, string $compare = '=', string $type = 'CHAR'): static
    {
        $new = clone $this;

        $new->addExpression(CustomFieldExpr::class, [[$field, $value, $compare, $type]]);

        return $new;
    }
}