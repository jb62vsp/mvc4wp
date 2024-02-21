<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Attribute;
use Mvc4Wp\Core\Library\Castable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Bindable
{
    use Castable, AttributeTrait;

    public function __construct() {
    }
}