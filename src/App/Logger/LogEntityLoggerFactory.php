<?php declare(strict_types=1);
namespace App\Logger;

use Psr\Log\LoggerInterface;
use Mvc4Wp\Core\Exception\ApplicationException;
use Mvc4Wp\Core\Logger\AbstractLoggerFactory;

class LogEntityLoggerFactory extends AbstractLoggerFactory
{
    private const LOG_LEVEL_KEY = 'log_level';

    public static function create(array $args = []): LoggerInterface
    {
        if (!array_key_exists(self::LOG_LEVEL_KEY, $args)) {
            throw new ApplicationException('invalid log config: ' . self::LOG_LEVEL_KEY);
        }

        return new LogEntityLogger($args[self::LOG_LEVEL_KEY]);
    }
}