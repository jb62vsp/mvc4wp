<?php declare(strict_types=1);
namespace System\Models;

use System\Core\Cast;
use System\Models\Repository\RepositoryInterface;
use System\Models\Repository\RepositoryTrait;

abstract class Model implements BindInterface, RepositoryInterface
{
    use Cast, BindTrait, RepositoryTrait;

    #[Bindable]
    public int $ID;

    public function isLoaded(): bool
    {
        return isset($this->ID);
    }
}