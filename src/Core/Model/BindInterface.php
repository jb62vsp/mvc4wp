<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Model\Validator\ValidationError;

interface BindInterface
{
    public function idBinded(): bool;

    /**
     * @return array<ValidationError>
     */
    public function bind(object|array $data, bool $validation = true): array;
}