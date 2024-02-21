<?php declare(strict_types=1);
namespace Mvc4Wp\System\Model;

use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Model\Repository\QueryInterface;
use Mvc4Wp\System\Model\Repository\RepositoryInterface;

/**
 * @template TModel of Model
 * @implements RepositoryInterface<TModel, QueryInterface<TModel>>
 */
#[Entity]
abstract class Model implements BindInterface, RepositoryInterface
{
    use Cast, BindTrait;

    #[Bindable]
    public readonly int $ID;

    public function isLoaded(): bool
    {
        return isset($this->ID);
    }

    private function setValue(string $property, mixed $value): void
    {
        if ($property === 'ID') {
            if (!$this->isLoaded()) {
                $this->{$property} = $value;
            }
        } else {
            $this->{$property} = $value;
        }
    }
}