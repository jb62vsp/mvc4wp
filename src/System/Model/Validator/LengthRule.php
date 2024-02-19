<?php declare(strict_types=1);
namespace Mvc4Wp\System\Model\Validator;

use Attribute;
use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Model\AttributeTrait;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class LengthRule extends Rule
{
    use Cast, AttributeTrait;

    public function __construct(
        public int $min = 0,
        public int $max = PHP_INT_MAX,
        public string $message = '',
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
        return sprintf($this->message, $this->min, $this->max);
    }
}