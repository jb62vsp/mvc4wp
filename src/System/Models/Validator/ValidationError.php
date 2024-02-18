<?php declare(strict_types=1);
namespace System\Models\Validator;

use System\Core\Cast;

class ValidationError
{
    use Cast;

    public function __construct(
        public string $class_name,
        public string $property_name,
        public string $value,
        public Rule $rule,
    ) {
    }
}