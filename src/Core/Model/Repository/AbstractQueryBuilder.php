<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Library\Castable;

abstract class AbstractQueryBuilder
{
    use Castable, Querable;
}