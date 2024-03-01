<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Order;

use Mvc4Wp\Core\Exception\QueryBuildViolationException;
use Mvc4Wp\Core\Model\Repository\Expr;

class TermOrderByExpr implements Expr
{
    public const NAME = 'name';

    public const SLUG = 'slug';

    public const TERM_GROUP = 'term_group';

    public const TERM_ID = 'term_id';

    public const ID = 'id';

    public const DESCRIPTION = 'description';

    public const PARENT = 'parent';

    public const TERM_ORDER = 'term_order';

    public const COUNT = 'count';

    public const INCLUDE = 'include';

    public const SLUG__IN = 'slug__in';

    /** @deprecated */
    public const META_VALUE = 'meta_value';

    /** @deprecated */
    public const META_VALUE_NUM = 'meta_value_num';

    private const EMBEDDED_FIELDS = [
        self::NAME,
        self::SLUG,
        self::TERM_GROUP,
        self::TERM_ID,
        self::ID,
        self::DESCRIPTION,
        self::PARENT,
        self::TERM_ORDER,
        self::COUNT,
        self::INCLUDE ,
        self::SLUG__IN,
        self::META_VALUE,
        self::META_VALUE_NUM,
    ];

    public function toQuery(array $contexts, array $query): array
    {
        if (empty($contexts)) {
            return $query;
        }

        foreach ($contexts as $orderby => $context) {
            [$order, $type] = $this->tuplize($context);
            if (in_array($orderby, self::EMBEDDED_FIELDS)) {
                $query['order'] = $order;
                $query['orderby'] = $orderby;
            } else {
                $query = $this->setCustomField($orderby, $type, $query);
            }
        }

        return $query;
    }

    private function setCustomField(string $orderby, $type, array $query): array
    {
        if (!array_key_exists('meta_query', $query)) {
            $query['meta_query'] = [];
        }

        if (!array_key_exists('relation', $query['meta_query']) && (count($query['meta_query']) > 0)) {
            $query['meta_query']['relation'] = 'AND';
        }

        $query['meta_query'][$orderby] = [
            'key' => $orderby,
            'compare' => 'EXISTS',
            'type' => $type,
        ];

        return $query;
    }

    /**
     * @return list<string, string, string>
     */
    protected function tuplize(array $context): array
    {
        [$order, $type] = $context;

        if (is_null($order)) {
            throw new QueryBuildViolationException("order"); // TODO:
        }
        if (is_null($type)) {
            throw new QueryBuildViolationException("type"); // TODO:
        }

        return $context;
    }
}