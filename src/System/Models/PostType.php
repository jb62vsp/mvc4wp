<?php declare(strict_types=1);
namespace System\Models;

use Attribute;
use System\Core\Cast;

#[Attribute(Attribute::TARGET_CLASS)]
class PostType extends Entity
{
    use Cast, AttributeTrait;

    public function __construct(
        public string $name,
    ) {
    }

    public static function getName(string $class_name): string
    {
        return self::getSingleClassAttributeValue($class_name, 'name');
    }
}