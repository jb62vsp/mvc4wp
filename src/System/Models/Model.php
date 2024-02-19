<?php declare(strict_types=1);
namespace Mvc4Wp\System\Models;

use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Models\Repository\QueryInterface;
use Mvc4Wp\System\Models\Repository\RepositoryInterface;

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