<?php declare(strict_types=1);
namespace Mvc4Wp\System\Model;

use Attribute;
use Mvc4Wp\System\Library\Cast;

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
        $attr = static::getClassAttribute($class_name);
        return $attr->name;
    }
}