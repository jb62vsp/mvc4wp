<?php declare(strict_types=1);
namespace System\Models\Repository;

use System\Core\Cast;

class UserQuery extends AbstractQuery
{
    use Cast, UserQueryTrait;
}