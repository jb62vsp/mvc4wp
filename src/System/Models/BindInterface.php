<?php declare(strict_types=1);
namespace Wp4Mvc\System\Models;

use Wp4Mvc\System\Models\Validator\ValidationError;

interface BindInterface
{
    public function idBinded(): bool;

    /**
     * @return array<ValidationError>
     */
    public function bind(object|array $data, bool $validation = true): array;
}