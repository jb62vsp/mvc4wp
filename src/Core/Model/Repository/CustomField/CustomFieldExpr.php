<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\CustomField;

use Mvc4Wp\Core\Exception\QueryBuildViolationException;
use Mvc4Wp\Core\Model\Model;
use Mvc4Wp\Core\Model\Repository\Expr;

/**
 * @template TModel of Model
 * @implements Expr<TModel>
 */
class CustomFieldExpr implements Expr
{
    /**
     * @param array<list<string, mixed, string, string>> $context
     */
    public function toQuery(array $contexts): array
    {
        if (empty($contexts)) {
            return [];
        } elseif (count($contexts) === 1) {
            [$field, $value, $compare, $type] = $this->tuplize($contexts[0]);

            return [
                'meta_query' => [
                    [
                        'key' => $field,
                        'value' => $value,
                        'compare' => $compare,
                        'type' => $type,
                    ],
                ],
            ];
        } else {
            $result = [
                'relation' => 'AND',
            ];
            foreach ($contexts as $context) {
                [$field, $value, $compare, $type] = $this->tuplize($context);
                array_push($result, [
                    'key' => $field,
                    'value' => $value,
                    'compare' => $compare,
                    'type' => $type,
                ]);
            }
            return ['meta_query' => $result];
        }
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