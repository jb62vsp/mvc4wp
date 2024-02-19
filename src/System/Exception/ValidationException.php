<?php declare(strict_types=1);
namespace Wp4Mvc\System\Exception;

use RuntimeException;

class ValidationException extends RuntimeException
{
    public function __construct(
        public string $class,
        public string $field,
        public string $value,
        public string $pattern,
    ) {
        parent::__construct(message: "invalid: '{$value}' => {$pattern}, {$class}::{$field}");
    }
}