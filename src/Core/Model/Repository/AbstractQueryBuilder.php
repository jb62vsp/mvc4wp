<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Repository\Order\OrderQuerable;
use Mvc4Wp\Core\Model\Repository\Raw\RawQuerable;

abstract class AbstractQueryBuilder
{
    use
        Castable,
        OrderQuerable,
        Querable,
        RawQuerable;
}