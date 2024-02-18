<?php declare(strict_types=1);
namespace System\Models;

use Attribute;
use System\Core\Cast;

#[Attribute(Attribute::TARGET_CLASS)]
class CustomPostType
{
    use Cast, AttributeTrait;
    
    public function __construct(
        public string $name,
        public string $title,
    ) {
    }
}