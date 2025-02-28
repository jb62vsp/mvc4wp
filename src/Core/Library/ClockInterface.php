<?php

declare(strict_types=1);

namespace Mvc4Wp\Core\Library;

use DateTimeInterface;
use DateTimeZone;

interface ClockInterface
{
    public static function get(string $datetime = "now", DateTimeZone $timezone = null): DateTimeInterface;
}
