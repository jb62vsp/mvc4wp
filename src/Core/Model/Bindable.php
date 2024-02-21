<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Attribute;
use Mvc4Wp\Core\Library\Cast;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Bindable
{
    use Cast, AttributeTrait;

    public function __construct() {
    }
}