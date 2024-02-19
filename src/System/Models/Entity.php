<?php declare(strict_types=1);
namespace Wp4Mvc\System\Models;

use Attribute;
use Wp4Mvc\System\Core\Cast;

#[Attribute(Attribute::TARGET_CLASS)]
class Entity
{
    use Cast, AttributeTrait;
}