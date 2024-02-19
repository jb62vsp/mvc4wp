<?php declare(strict_types=1);
namespace Mvc4Wp\System\Models\Validator;

use Attribute;
use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Models\AttributeTrait;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class LengthRule extends Rule
{
    use Cast, AttributeTrait;

    public function __construct(
        public int $min = 0,
        public int $max = PHP_INT_MAX,
    ) {
    }

    public function _validate(string $class_name, string $property_name, mixed $value): array
    {
        $result = [];

        $length = strlen(strval($value));
        if ($length < $this->min || $this->max < $length) {
            array_push($result, new ValidationError($class_name, $property_name, $value, $this));
        }

        return $result;
    }

    public function getMessage(array $args = []): string
    {
        return ''; // TODO: message
    }
}