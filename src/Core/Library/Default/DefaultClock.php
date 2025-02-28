<?php

declare(strict_types=1);

namespace Mvc4Wp\Core\Library\Default;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Library\ClockInterface;

class DefaultClock implements ClockInterface
{
    use Castable;

    public static function get(string $datetime = "now", DateTimeZone $timezone = null): DateTimeInterface
    {
        if (is_null($timezone)) {
            $timezone = new DateTimeZone(ini_get('date.timezone'));
        }
        return new DateTimeImmutable($datetime, $timezone);
    }
}
