<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library;

use DateTime;
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

    public static function now(string|null $format = null): string
    {
        if (is_null($format)) {
            $datetime = App::get()->clock()->get('now', self::getTimeZone());
            return $datetime->format(self::getDateFormat());
        } else {
            $datetime = App::get()->clock()->get('now', self::getTimeZone());
            return $datetime->format($format);
        }
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

    // convert

    public static function datetimeval(DateTimeInterface|string $value): DateTimeInterface
    {
        return ($value instanceof DateTimeInterface) ? $value : App::get()->clock()->get($value, self::getTimeZone());
    }

    public static function dateval(int $year, int $month, int $day): DateTimeInterface
    {
        return self::datetimeval(sprintf('%04d-%02d-%02d', $year, $month, $day));
    }

    public static function timeval(int $hour, int $minute, $second): DateTimeInterface
    {
        return self::datetimeval(sprintf('%02d:%02d:%02d', $hour, $minute, $second));
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
        $datetime = self::datetimeval($value);
        return self::strval($datetime, $format);
    }

    // getter

    public static function fromYMD(int $year, int $month, int $day): DateTimeInterface
    {
        return new DateTimeImmutable(sprintf('%04d-%02d-%02d', $year, $month, $day));
    }

    public static function fromHMS(int $hour, int $minute, int $second): DateTimeInterface
    {
        return new DateTimeImmutable(sprintf('%02d:%02d:%02d', $hour, $minute, $second));
    }

    private static function _getUnit(string $format, DateTimeInterface|string|null $datetime = null): int
    {
        if (is_null($datetime)) {
            return intval(self::now($format));
        } else {
            return intval(self::strval(self::datetimeval($datetime), $format));
        }
    }

    public static function year(DateTimeInterface|string|null $datetime = null): int
    {
        return self::_getUnit(self::YEAR, $datetime);
    }

    public static function month(DateTimeInterface|string|null $datetime = null): int
    {
        return self::_getUnit(self::MONTH, $datetime);
    }

    public static function day(DateTimeInterface|string|null $datetime = null): int
    {
        return self::_getUnit(self::DAY, $datetime);
    }

    public static function hour(DateTimeInterface|string|null $datetime = null): int
    {
        return self::_getUnit(self::HOUR, $datetime);
    }

    public static function minute(DateTimeInterface|string|null $datetime = null): int
    {
        return self::_getUnit(self::MINUTE, $datetime);
    }

    public static function second(DateTimeInterface|string|null $datetime = null): int
    {
        return self::_getUnit(self::SECOND, $datetime);
    }

    // utility

    public static function firstDayOf(int $year, int $month): DateTimeInterface
    {
        return self::fromYMD($year, $month, 1);
    }

    public static function lastDayOf(int $year, int $month): DateTimeInterface
    {
        return self::fromYMD($year, $month, 1)->modify('last day of');
    }

    public static function firstDayOfLastMonth(int $year, int $month): DateTimeInterface
    {
        return self::fromYMD($year, $month, 1)->modify('first day of last month');
    }

    public static function firstDayOfNextMonth(int $year, int $month): DateTimeInterface
    {
        return self::fromYMD($year, $month, 1)->modify('first day of next month');
    }
}
