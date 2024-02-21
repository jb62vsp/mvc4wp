<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Logger\Default;

use DateTimeZone;
use Mvc4Wp\Core\Logger\FileLogger;

class DefaultFileLogger extends FileLogger
{
    protected int $threshold;

    protected static $thresholds = [
        'emergency' => 1,
        'alert' => 2,
        'critical' => 3,
        'error' => 4,
        'warning' => 5,
        'notice' => 6,
        'info' => 7,
        'debug' => 8,
    ];

    public function __construct(
        string $directory,
        string $basefilename,
        string $file_date_format,
        string $datetime_format,
        string $timezone,
        string $log_level,
    ) {
        parent::__construct(
            $directory,
            $basefilename,
            $file_date_format,
            $datetime_format,
            $timezone,
            $log_level,
        );
    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $threshold = $this->threshold;
        if (!array_key_exists($level, self::$thresholds)) {
            $threshold = self::$thresholds['debug'];
        }

        if (self::$thresholds[$level] <= $threshold) {
            $ts = time();
            $now = date_create('@' . $ts);
            $now->setTimezone(new DateTimeZone($this->timezone));
            $datetime = $now->format($this->datetime_format);
            $this->out($now, strtoupper($level) . ' - ' . $datetime . ' --> ' . $message . ', ' . var_export($context, true) . "\n");
        }
    }
}