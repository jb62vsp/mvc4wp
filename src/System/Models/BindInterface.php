<?php declare(strict_types=1);
namespace System\Models;

use System\Models\Validator\ValidationError;

interface BindInterface
{
    public function idBinded(): bool;

    /**
     * @return array<ValidationError>
     */
    public function bind(object|array $data, bool $validation = true): array;
}