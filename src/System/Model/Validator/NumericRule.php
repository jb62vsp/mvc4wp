<?php declare(strict_types=1);
namespace Mvc4Wp\System\Model\Validator;

use Attribute;
use Mvc4Wp\System\Library\Cast;
use Mvc4Wp\System\Model\AttributeTrait;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class NumericRule extends Rule
{
    use Cast, AttributeTrait;

    public function __construct(
        public string $message = '',
    ) {
    }

    public function _validate(string $class_name, string $property_name, mixed $value): array
    {
        $result = [];

        if (!is_numeric($value)) {
            array_push($result, new ValidationError($class_name, $property_name, $value, $this));
        }

        return $result;
    }

    public function getMessage(array $args = []): string
    {
        return $this->message;
    }
}