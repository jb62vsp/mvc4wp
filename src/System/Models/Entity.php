<?php declare(strict_types=1);
namespace Mvc4Wp\System\Models;

use Attribute;
use Mvc4Wp\System\Core\Cast;

#[Attribute(Attribute::TARGET_CLASS)]
class Entity
{
    use Cast, AttributeTrait;
}