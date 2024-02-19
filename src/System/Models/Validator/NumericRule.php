<?php declare(strict_types=1);
namespace Wp4Mvc\System\Models\Validator;

use Attribute;
use Wp4Mvc\System\Core\Cast;
use Wp4Mvc\System\Models\AttributeTrait;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class NumericRule extends Rule
{
    use Cast, AttributeTrait;

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
        return ''; // TODO: message
    }
}