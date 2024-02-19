<?php declare(strict_types=1);
namespace Wp4Mvc\System\Models;

use Wp4Mvc\System\Core\Cast;
use Wp4Mvc\System\Models\Repository\QueryInterface;
use Wp4Mvc\System\Models\Repository\RepositoryInterface;

/**
 * @template TModel of Model
 * @implements RepositoryInterface<TModel, QueryInterface<TModel>>
 */
abstract class Model implements BindInterface, RepositoryInterface
{
    use Cast, BindTrait;

    #[Bindable]
    public int $ID;

    public function isLoaded(): bool
    {
        return isset($this->ID);
    }
}