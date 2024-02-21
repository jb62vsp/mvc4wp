<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Helper;

use DateTime;
use DateTimeZone;
use Mvc4Wp\Core\Library\Clock;

final class DateTimeHelper
{
    public static function getTimeZone(): DateTimeZone
    {
        return get_option('timezone_string');
    }

    public static function getDateFormat(): string
    {
        return get_option('date_format');
    }

    public static function getTimeFormat(): string
    {
        return get_option('time_format');
    }

    public static function getDateTimeFormat(): string
    {
        return get_option('links_updated_date_format');
    }

    public static function now(string $format): string
    {
        return wp_date($format);
    }

    public static function datetime(): string
    {
        return self::now(self::getDateTimeFormat());
    }

    public static function date(): string
    {
        return self::now(self::getDateFormat());
    }

    public static function time(): string
    {
        return self::now(self::getTimeFormat());
    }

    public static function datetimeval(DateTime|string $value): DateTime
    {
        return ($value instanceof DateTime) ? $value : new DateTime($value);
    }

    public static function strval(DateTime|null $value, string $format): string
    {
        if (is_null($value)) {
            return '';
        }
        return $value->format($format);
    }
}