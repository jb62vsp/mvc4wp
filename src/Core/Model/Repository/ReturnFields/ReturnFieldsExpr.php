<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\ReturnFields;

use Mvc4Wp\Core\Model\Model;
use Mvc4Wp\Core\Model\Repository\Expr;

/**
 * @template TModel of Model
 * @implements Expr<TModel>
 */
class ReturnFieldsExpr implements Expr
{
    public function toQuery(array $contexts): array
    {
        if (empty($contexts)) {
            return [];
        } else {
            return ['fields' => $contexts[0]];
        }
    }
}