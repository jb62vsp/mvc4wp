<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Validation;

use Attribute;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\AttributeTrait;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class NumericRule extends Rule
{
    use Castable, AttributeTrait;

    public function __construct(
        public string $message = '',
    ) {
    }

    public function _validate(string $class_name, string $property_name, mixed $value): array
    {
        $result = [];

        if (!empty($value) && !is_numeric($value)) {
            $result[] = new ValidationError($class_name, $property_name, $value, $this);
        }

        return $result;
    }

    public function getMessage(array $args = []): string
    {
        return $this->message;
    }
}