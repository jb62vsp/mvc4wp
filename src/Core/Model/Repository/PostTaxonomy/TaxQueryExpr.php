<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostTaxonomy;

use Mvc4Wp\Core\Exception\QueryBuildViolationException;
use Mvc4Wp\Core\Model\Repository\Expr;

class TaxQueryExpr implements Expr
{
    public function toQuery(array $contexts, array $query): array
    {
        if (empty($contexts)) {
            return $query;
        }

        if (!array_key_exists('tax_query', $query)) {
            $query['tax_query'] = [];
        }

        if (!array_key_exists('relation', $query['tax_query']) && (count($query['tax_query']) > 0 || count($contexts) > 1)) {
            $query['tax_query']['relation'] = 'AND';
        }

        foreach ($contexts as $context) {
            [$taxonomy, $field, $terms, $include_children, $operator] = $this->tuplize($context);
            $query['tax_query'][] = [
                'taxonomy' => $taxonomy,
                'field' => $field,
                'terms' => $terms,
                'include_children' => $include_children,
                'operator' => $operator,
            ];
        }

        return $query;
    }

    /**
     * @return list<string, string, int|string|array, boolean, string>
     */
    protected function tuplize(array $context): array
    {
        [$taxonomy, $field, $terms, $include_children, $operator] = $context;

        if (is_null($taxonomy)) {
            throw new QueryBuildViolationException("taxonomy"); // TODO:
        }
        if (is_null($field)) {
            throw new QueryBuildViolationException("field"); // TODO:
        }
        if (is_null($terms)) {
            throw new QueryBuildViolationException("terms"); // TODO:
        }
        if (is_null($include_children)) {
            throw new QueryBuildViolationException("include_children"); // TODO:
        }
        if (is_null($operator)) {
            throw new QueryBuildViolationException("operator"); // TODO:
        }

        return $context;
    }
}