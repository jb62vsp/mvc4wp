<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library;

use DateTime;
use DateTimeZone;

class Clock implements ClockInterface
{
    public static function get(string $datetime = "now", DateTimeZone $timezone = null): DateTime
    {
        return new DateTime($datetime, $timezone);
    }
}