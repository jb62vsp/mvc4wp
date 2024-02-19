<?php declare(strict_types=1);
namespace System\Models\Repository;

use System\Core\Cast;

abstract class AbstractQuery implements QueryInterface
{
    use Cast, QueryTrait;
}