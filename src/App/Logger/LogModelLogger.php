<?php declare(strict_types=1);
namespace App\Logger;

use App\Model\LogModel;
use Psr\Log\AbstractLogger;
use Mvc4Wp\System\Helper\DateTimeHelper;

class LogModelLogger extends AbstractLogger
{
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

    protected int $threshold;

    public function __construct(
        string $log_level,
    ) {
        if (array_key_exists($log_level, self::$thresholds)) {
            $this->threshold = self::$thresholds[$log_level];
        } else {
            $this->threshold = self::$thresholds['debug'];
        }
    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $threshold = $this->threshold;
        if (!array_key_exists($level, self::$thresholds)) {
            $threshold = self::$thresholds['debug'];
        }

        if (self::$thresholds[$level] <= $threshold) {
            $model = new LogModel();
            $date = DateTimeHelper::datetime();
            $model->post_title = $date . '-' . strtoupper($level) . ' --> ' . $message;
            $model->post_content = var_export($context, true);
            $model->register(true);
        }
    }
}