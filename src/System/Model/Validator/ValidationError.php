<?php declare(strict_types=1);
namespace Mvc4Wp\System\Model\Validator;

use Mvc4Wp\System\Library\Cast;

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