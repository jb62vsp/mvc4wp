<?php declare(strict_types=1);
namespace Mvc4Wp\System\Model\Repository;

use Mvc4Wp\System\Library\Cast;
use Mvc4Wp\System\Model\Model;

/**
 * @template TModel of Model
 * @implements QueryInterface<TModel>
 */
abstract class AbstractQuery implements QueryInterface
{
    use Cast;
}