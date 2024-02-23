<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Model;

/**
 * @template TModel of Model
 */
abstract class AbstractQueryBuilder
{
    /**
     * @use Querable<TModel>
     */
    use Castable, Querable;
}