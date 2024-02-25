<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Order;

use Mvc4Wp\Core\Exception\QueryBuildViolationException;
use Mvc4Wp\Core\Model\Repository\Expr;

class OrderByExpr implements Expr
{
    // ---- COMMON FIELDS ----

    public const ID = 'ID';

    public const NAME = 'name';

    /** @deprecated */
    public const META_VALUE = 'meta_value';

    /** @deprecated */
    public const META_VALUE_NUM = 'meta_value_num';

    // ---- POST FIELDS ----

    public const NONE = 'none';

    public const AUTHOR = 'author';

    public const TITLE = 'title';

    public const TYPE = 'type';

    public const DATE = 'date';

    public const MODIFIED = 'modified';

    /** @deprecated */
    public const PARENT = 'parent';

    /** @deprecated */
    public const RAND = 'rand';

    /** @deprecated */
    public const COMMENT_COUNT = 'comment_count';

    /** @deprecated */
    public const RELEVANCE = 'relevance';

    /** @deprecated */
    public const MENU_ORDER = 'menu_order';

    /** @deprecated */
    public const POST__IN = 'post__in';

    /** @deprecated */
    public const POST_NAME__IN = 'post_name__in';

    /** @deprecated */
    public const POST_PARENT__IN = 'post_parent__in';

    // ---- USER FIELDS ----

    public const DISPLAY_NAME = 'display_name';

    /** @deprecated */
    public const INCLUDE = 'include';

    public const LOGIN = 'login';

    public const NICENAME = 'nicename';

    public const EMAIL = 'email';

    public const URL = 'url';

    public const REGISTERED = 'registered';

    public const POST_COUNT = 'post_count';

    private const EMBEDDED_FIELDS = [
        self::NONE,
        self::ID,
        self::NAME,
        self::NONE,
        self::AUTHOR,
        self::TITLE,
        self::TYPE,
        self::DATE,
        self::MODIFIED,
        self::PARENT,
        self::RAND,
        self::COMMENT_COUNT,
        self::RELEVANCE,
        self::MENU_ORDER,
        self::POST__IN,
        self::POST_NAME__IN,
        self::POST_PARENT__IN,
        self::DISPLAY_NAME,
        self::INCLUDE ,
        self::LOGIN,
        self::NICENAME,
        self::EMAIL,
        self::URL,
        self::REGISTERED,
        self::POST_COUNT,
    ];

    private const EMBEDDED_ORDER_FIELDS_CONVERT = [
        'none' => self::NONE,
        'ID' => self::ID,
        'id' => self::ID,
        'post_author' => self::AUTHOR,
        'post_title' => self::TITLE,
        'post_name' => self::NAME,
        'post_type' => self::TYPE,
        'post_date' => self::DATE,
        'modified' => self::MODIFIED,
        'parent' => self::PARENT,
        'rand' => self::RAND,
        'comment_count' => self::COMMENT_COUNT,
        'relevance' => self::RELEVANCE,
        'menu_order' => self::MENU_ORDER,
        'meta_value' => self::META_VALUE,
        'meta_value_num' => self::META_VALUE_NUM,
        'post__in' => self::POST__IN,
        'post_name__in' => self::POST_NAME__IN,
        'post_parent__in' => self::POST_PARENT__IN,
    ];

    public function toQuery(array $contexts, array $query): array
    {
        if (empty($contexts)) {
            return $query;
        }

        $query['orderby'] = [];
        foreach ($contexts as $orderby => $context) {
            [$order, $type] = $this->tuplize($context);
            if (array_key_exists($orderby, self::EMBEDDED_ORDER_FIELDS_CONVERT)) {
                $orderby = self::EMBEDDED_ORDER_FIELDS_CONVERT[$orderby];
            } elseif (!in_array($orderby, self::EMBEDDED_FIELDS)) {
                $query = $this->setCustomField($orderby, $type, $query);
            }
            $query['orderby'][$orderby] = $order;
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