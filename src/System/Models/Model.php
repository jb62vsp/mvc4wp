<?php declare(strict_types=1);
namespace System\Models;

use System\Core\Cast;

abstract class Model implements BindInterface, RepositoryInterface
{
    use Cast, BindTrait, RepositoryTrait;

    #[Bindable]
    protected int $ID;

    public function getID(): int
    {
        return $this->ID;
    }

    public function isLoaded(): bool
    {
        return isset($this->ID);
    }
}