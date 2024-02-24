<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\CustomField;

use Mvc4Wp\Core\Exception\QueryBuildViolationException;
use Mvc4Wp\Core\Model\Repository\Expr;

class CustomFieldExpr implements Expr
{
    /**
     * @param array<list<string, mixed, string, string>> $contexts
     */
    public function toQuery(array $contexts, array $query): array
    {
        if (empty($contexts)) {
            return $query;
        }

        if (!array_key_exists('meta_query', $query)) {
            $query['meta_query'] = [];
        }

        if (!array_key_exists('relation', $query['meta_query']) && (count($query['meta_query']) > 0 || count($contexts) > 1)) {
            $query['meta_query']['relation'] = 'AND';
        }

        foreach ($contexts as $context) {
            [$field, $value, $compare, $type] = $this->tuplize($context);
            $query['meta_query'][] = [
                'key' => $field,
                'value' => $value,
                'compare' => $compare,
                'type' => $type,
            ];
        }

        return $query;
    }

    /**
     * @return list<string, mixed, string, string>
     */
    protected function tuplize(array $context): array
    {
        [$field, $value, $compare, $type] = $context;

        if (is_null($field)) {
            throw new QueryBuildViolationException("field"); // TODO:
        }
        if (is_null($value)) {
            throw new QueryBuildViolationException("value"); // TODO:
        }
        if (is_null($compare)) {
            throw new QueryBuildViolationException("compare"); // TODO:
        }
        if (is_null($type)) {
            throw new QueryBuildViolationException("type"); // TODO:
        }

        return $context;
    }
}