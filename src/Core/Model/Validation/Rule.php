<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Validation;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\AttributeTrait;

abstract class Rule
{
    use Castable, AttributeTrait;

    abstract public function getMessage(array $args = []): string;

    /**
     * @return array<string, ValidationError>
     */
    abstract public function validate(string $class_name, string $property_name, mixed $value): array;
}