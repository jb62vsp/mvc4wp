<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\CustomField;

use Mvc4Wp\Core\Model\Repository\CompareInQuery;
use Mvc4Wp\Core\Model\Repository\TypeInQuery;

/**
 * @see https://developer.wordpress.org/reference/classes/wp_query/#custom-field-post-meta-parameters
 */
trait CustomFieldQuerable
{
    /**
     * CAUTION - custom field only
     * @param string $field Custom field key.
     * @param string|int|array $value Custom field value.
     * @param CompareInQuery $compare Operator to test.
     * Default value is '='.
     * @param TypeInQuery $type Custom field type.
     * Default value is 'CHAR'.
     */
    public function by(string $field, string|int|array $value, CompareInQuery $compare = CompareInQuery::EQ, TypeInQuery $type = TypeInQuery::CHAR): static
    {
        $new = clone $this;

        $new->addExpression(CustomFieldExpr::class, [[$field, $value, $compare->value, $type->value]]);

        return $new;
    }
}