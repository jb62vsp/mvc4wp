<?php declare(strict_types=1);
namespace System\Models;

use Attribute;
use DateTime;

#[Attribute(Attribute::TARGET_PROPERTY)]
class BindableField
{

    public function __construct(
        public bool|int|float|array|DateTime|string|null $default_value = null,
    ) {
    }
}