<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Attribute;

use Attribute;
use Mvc4Wp\Core\Library\Castable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class UserCustomField extends Field
{
    use Castable, AttributeTrait;

    public function __construct(
        public string $title,
    ) {
    }

    public static function getTitle(string $class_name, string $property_name): string
    {
        $attr = static::getPropertyAttribute($class_name, $property_name);
        return $attr->title;
    }
}