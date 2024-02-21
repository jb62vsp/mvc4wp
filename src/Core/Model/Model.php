<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Repository\QueryInterface;
use Mvc4Wp\Core\Model\Repository\RepositoryInterface;

/**
 * @template TModel of Model
 * @implements RepositoryInterface<TModel, QueryInterface<TModel>>
 */
#[Entity]
abstract class Model implements RepositoryInterface
{
    use Bindable, Castable;

    #[Field]
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