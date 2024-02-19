<?php declare(strict_types=1);
namespace Wp4Mvc\System\Models\Repository;

use Wp4Mvc\System\Core\Cast;
use Wp4Mvc\System\Models\Model;

/**
 * @template TModel of Model
 * @implements QueryInterface<TModel>
 */
abstract class AbstractQuery implements QueryInterface
{
    use Cast;
}