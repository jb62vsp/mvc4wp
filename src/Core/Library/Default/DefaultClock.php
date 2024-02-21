<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library\Default;

use DateTime;
use DateTimeZone;
use Mvc4Wp\Core\Library\ClockInterface;

class DefaultClock implements ClockInterface
{
    public static function get(string $datetime = "now", DateTimeZone $timezone = null): DateTime
    {
        return new DateTime($datetime, $timezone);
    }
}