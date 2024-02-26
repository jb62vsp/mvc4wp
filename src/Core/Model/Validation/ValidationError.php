<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Validation;

use Mvc4Wp\Core\Library\Castable;

class ValidationError
{
    use Castable;

    public function __construct(

        /**
         * @var string $class_name
         */
        public string $class_name,

        /**
         * @var string $class_name
         */
        public string $property_name,

        /**
         * @var string $class_name
         */
        public string $value,

        /**
         * @var Rule $rule
         */
        public Rule $rule,
    ) {
    }
}