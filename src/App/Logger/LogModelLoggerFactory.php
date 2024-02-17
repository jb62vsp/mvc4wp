<?php declare(strict_types=1);
namespace App\Logger;

use Psr\Log\LoggerInterface;
use System\Exception\ApplicationException;
use System\Logger\AbstractLoggerFactory;

class LogModelLoggerFactory extends AbstractLoggerFactory
{
    private const LOG_LEVEL_KEY = 'log_level';

    public function create(string $logger, array $config): LoggerInterface
    {
        if (!array_key_exists(self::LOG_LEVEL_KEY, $config)) {
            throw new ApplicationException('invalid log config: ' . self::LOG_LEVEL_KEY);
        }

        return new LogModelLogger($config[self::LOG_LEVEL_KEY]);
    }
}