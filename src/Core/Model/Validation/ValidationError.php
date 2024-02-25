<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Validation;

use Mvc4Wp\Core\Library\Castable;

class ValidationError
{
    use Castable;

    public function __construct(
        public string $class_name,
        public string $property_name,
        public string $value,
        public Rule $rule,
    ) {
    }
}