<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Validation;

use Mvc4Wp\Core\Language\MessagerInterface;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\AttributeTrait;

abstract class Rule
{
    use Castable, AttributeTrait;

    abstract public function getMessage(MessagerInterface $messager, array $args = []): string;

    /**
     * @param string $class_name
     * @param string $property_name
     * @param mixed $value
     * @return array<string, ValidationError>
     */
    abstract public function validate(string $class_name, string $property_name, mixed $value): array;
}