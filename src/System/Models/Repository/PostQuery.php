<?php declare(strict_types=1);
namespace System\Models\Repository;

use System\Core\Cast;
use System\Models\Repository\AbstractQuery;
use System\Models\Repository\PostQueryTrait;

class PostQuery extends AbstractQuery
{
    use Cast, PostQueryTrait;
}