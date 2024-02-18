<?php declare(strict_types=1);
namespace System\Models;

use Attribute;
use ReflectionClass;
use ReflectionProperty;
use System\Core\Cast;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Bindable
{
    use Cast, AttributeTrait;

    public function __construct() {
    }
}