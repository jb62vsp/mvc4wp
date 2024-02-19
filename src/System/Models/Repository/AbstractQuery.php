<?php declare(strict_types=1);
namespace System\Models\Repository;

use System\Core\Cast;
use System\Models\Model;

/**
 * @template TModel of Model
 * @implements QueryInterface<TModel>
 */
abstract class AbstractQuery implements QueryInterface
{
    use Cast;
}