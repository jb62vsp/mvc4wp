<?php declare(strict_types=1);
namespace System\Models;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class PostType
{
    public function __construct(
        public string $post_type = '',
    ) {}
}