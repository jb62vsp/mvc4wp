<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Repository\RepositoryInterface;

abstract class Entity implements RepositoryInterface
{
    use Castable, Bindable, Validatable;
}