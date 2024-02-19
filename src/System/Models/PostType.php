<?php declare(strict_types=1);
namespace Wp4Mvc\System\Models;

use Attribute;
use Wp4Mvc\System\Core\Cast;

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