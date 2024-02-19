<?php declare(strict_types=1);
namespace Mvc4Wp\System\Model;

use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Model\Repository\QueryInterface;
use Mvc4Wp\System\Model\Repository\RepositoryInterface;

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