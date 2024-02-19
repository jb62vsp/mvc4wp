<?php declare(strict_types=1);
namespace Wp4Mvc\System\Models\Validator;

use Wp4Mvc\System\Core\Cast;

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