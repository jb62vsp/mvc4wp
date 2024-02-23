<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\CustomField;

/**
 * @see https://developer.wordpress.org/reference/classes/wp_query/#custom-field-post-meta-parameters
 */
trait CustomFieldQuerable
{
    /**
     * CAUTION - custom field only
     * @param string $field Custom field key.
     * @param string|int|array $value Custom field value.
     * @param string $compare Operator to test.
     * Possible values are '=', '!=', '>', '>=', '<', '<=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN', 'EXISTS' and 'NOT EXISTS'.
     * Default value is '='.
     * @param string $type Custom field type.
     * Possible values are 'NUMERIC', 'BINARY', 'CHAR', 'DATE', 'DATETIME', 'DECIMAL', 'SIGNED', 'TIME', 'UNSIGNED'.
     * Default value is 'CHAR'.
     */
    public function by(string $field, string|int|array $value, string $compare = '=', string $type = 'CHAR'): static
    {
        $new = clone $this;

        $new->addExpression(CustomFieldExpr::class, [[$field, $value, $compare, $type]]);

        return $new;
    }
}