<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Model;

/**
 * @template TModel of Model
 * @implements QueryInterface<TModel>
 */
abstract class AbstractQuery implements QueryInterface
{
    use Castable;
}