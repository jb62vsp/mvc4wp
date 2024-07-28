<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Order;

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

        foreach ($contexts as $orderby => $order) {
            if (in_array($orderby, self::EMBEDDED_FIELDS)) {
                $query['orderby'] = $orderby;
            } else {
                $query['orderby'] = self::META_VALUE;
                $query['meta_key'] = $orderby;
            }
            $query['order'] = $order;
        }

        return $query;
    }
}