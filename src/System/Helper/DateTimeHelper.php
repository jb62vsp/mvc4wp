<?php declare(strict_types=1);
namespace System\Helper;

use DateTime;

final class DateTimeHelper
{
    public const DATE_FORMAT = 'Y-m-d';

    public const TIME_FORMAT = 'H:i:s';

    public const DATETIME_FORMAT = self::DATE_FORMAT . ' ' . self::TIME_FORMAT;

    public static function datetime(): string
    {
        return wp_date(self::DATETIME_FORMAT);
    }

    public static function date(): string
    {
        return wp_date(self::DATE_FORMAT);
    }

    public static function time(): string
    {
        return wp_date(self::TIME_FORMAT);
    }

    public static function datetimeval(DateTime|string $value): DateTime
    {
        return ($value instanceof DateTime) ? $value : new DateTime($value);
    }

    public static function strval(DateTime|null $value, string $format = self::DATETIME_FORMAT): string
    {
        if (is_null($value)) {
            return '';
        }
        return $value->format($format);
    }
}