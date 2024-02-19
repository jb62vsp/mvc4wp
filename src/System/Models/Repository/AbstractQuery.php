<?php declare(strict_types=1);
namespace Mvc4Wp\System\Models\Repository;

use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Models\Model;

/**
 * @template TModel of Model
 * @implements QueryInterface<TModel>
 */
abstract class AbstractQuery implements QueryInterface
{
    use Cast;
}