<?php declare(strict_types=1);
namespace Mvc4Wp\System\Logger;

use DateTime;
use DateTimeZone;
use Psr\Log\AbstractLogger;

class FileLogger extends AbstractLogger
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
        protected string $directory,
        protected string $basefilename,
        protected string $file_date_format,
        protected string $datetime_format,
        protected string $timezone,
        string $log_level,
    ) {
        if (array_key_exists($log_level, self::$thresholds)) {
            $this->threshold = self::$thresholds[$log_level];
        } else {
            $this->threshold = self::$thresholds['debug'];
        }
    }

    protected function getFilePath(string $date): string
    {
        $path = $this->directory . $this->basefilename . '.' . $date . '.log';
        return $path;
    }

    protected function out(DateTime $now, string $line): void
    {
        $date = $now->format($this->file_date_format);

        $create = false;

        if (!file_exists($this->getFilePath($date))) {
            $create = true;
        }

        if (!$fp = @fopen($this->getFilePath($date), 'ab')) {
            return;
        }

        flock($fp, LOCK_EX);
        $result = null;
        for ($i = 0, $il = strlen($line); $i < $il; $i += $result) {
            if (($result = fwrite($fp, substr($line, $i))) === false) {
                break;
            }
        }
        flock($fp, LOCK_UN);
        fclose($fp);

        if ($create) {
            chmod($this->getFilePath($date), 0666);
        }
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