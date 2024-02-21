<?php declare(strict_types=1);
namespace Mvc4Wp\System\Model;

use Attribute;
use Mvc4Wp\System\Library\Cast;

#[Attribute(Attribute::TARGET_CLASS)]
class CustomPostType extends PostType
{
    use Cast, AttributeTrait;

    public function __construct(
        public string $name,
        public string $title,
        public array $args = [],
    ) {
    }
}