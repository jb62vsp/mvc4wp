<?php

declare(strict_types=1);

namespace Mvc4Wp\Core\Library;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Mvc4Wp\Core\Service\App;

final class DateTimeUtils
{
    // format
    public const YEAR = 'Y';

    public const MONTH = 'm';

    public const MONTH_LONG = 'F';

    public const MONTH_SHORT = 'M';

    public const DAY = 'd';

    public const DOW = 'w';

    public const DOW_LONG = 'l';

    public const DOW_SHORT = 'D';

    public const HOUR = 'H';

    public const MINUTE = 'i';

    public const SECOND = 's';

    public const HOUR_MINUTE = 'H:i';

    // WordPress settings.

    public static function getTimeZone(): DateTimeZone
    {
        return new DateTimeZone(get_option('timezone_string'));
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

    // now

    public static function nowAsDateTime(): DateTimeInterface
    {
        return App::get()->clock()->get('now', static::getTimeZone());
    }

    public static function now(string|null $format = null): string
    {
        return static::nowAsDateTime()->format(is_null($format) ? static::getDateFormat() : $format);
    }

    public static function datetime(): string
    {
        return static::now(static::getDateTimeFormat());
    }

    public static function date(): string
    {
        return static::now(static::getDateFormat());
    }

    public static function time(): string
    {
        return static::now(static::getTimeFormat());
    }

    // convert

    public static function datetimeval(DateTimeInterface|string $value): DateTimeInterface
    {
        return ($value instanceof DateTimeInterface) ? $value : App::get()->clock()->get($value, static::getTimeZone());
    }

    public static function dateval(int $year, int $month, int $day): DateTimeInterface
    {
        return static::datetimeval(sprintf('%04d-%02d-%02d', $year, $month, $day));
    }

    public static function timeval(int $hour, int $minute, $second): DateTimeInterface
    {
        return static::datetimeval(sprintf('%02d:%02d:%02d', $hour, $minute, $second));
    }

    public static function strval(DateTimeInterface|null $value, string $format): string
    {
        if (is_null($value)) {
            return '';
        }
        return $value->format($format);
    }

    public static function format(DateTimeInterface|string $value, string $format): string
    {
        $datetime = static::datetimeval($value);
        return static::strval($datetime, $format);
    }

    // getter

    private static function _getUnit(string $format, DateTimeInterface|string|null $datetime = null): int
    {
        if (is_null($datetime)) {
            return intval(static::now($format));
        } else {
            return intval(static::strval(static::datetimeval($datetime), $format));
        }
    }

    public static function year(DateTimeInterface|string|null $datetime = null): int
    {
        return static::_getUnit(static::YEAR, $datetime);
    }

    public static function month(DateTimeInterface|string|null $datetime = null): int
    {
        return static::_getUnit(static::MONTH, $datetime);
    }

    public static function day(DateTimeInterface|string|null $datetime = null): int
    {
        return static::_getUnit(static::DAY, $datetime);
    }

    public static function hour(DateTimeInterface|string|null $datetime = null): int
    {
        return static::_getUnit(static::HOUR, $datetime);
    }

    public static function minute(DateTimeInterface|string|null $datetime = null): int
    {
        return static::_getUnit(static::MINUTE, $datetime);
    }

    public static function second(DateTimeInterface|string|null $datetime = null): int
    {
        return static::_getUnit(static::SECOND, $datetime);
    }

    // utility

    public static function cast(DateTimeInterface $value): DateTimeImmutable
    {
        return $value;
    }

    public static function firstDayOf(int $year, int $month): DateTimeInterface
    {
        return static::dateval($year, $month, 1);
    }

    public static function lastDayOf(int $year, int $month): DateTimeInterface
    {
        return static::cast(static::dateval($year, $month, 1))->modify('last day of');
    }

    public static function firstDayOfLastMonth(int $year, int $month): DateTimeInterface
    {
        return static::cast(static::dateval($year, $month, 1))->modify('first day of last month');
    }

    public static function firstDayOfNextMonth(int $year, int $month): DateTimeInterface
    {
        return static::cast(static::dateval($year, $month, 1))->modify('first day of next month');
    }
}
