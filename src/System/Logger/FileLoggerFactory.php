<?php declare(strict_types=1);
namespace System\Logger;

use Psr\Log\LoggerInterface;
use System\Exception\ApplicationException;
use System\Logger\AbstractLoggerFactory;

class FileLoggerFactory extends AbstractLoggerFactory
{
    private const DIRECTORY_KEY = 'directory';

    private const BASEFILENAME_KEY = 'basefilename';

    private const DATE_FORMAT_KEY = 'date_format';

    private const LOG_LEVEL_KEY = 'log_level';

    public function create(array $args = []): LoggerInterface
    {
        if (!array_key_exists(self::DIRECTORY_KEY, $args)) {
            throw new ApplicationException('invalid log config: ' . self::DIRECTORY_KEY);
        }
        if (!array_key_exists(self::BASEFILENAME_KEY, $args)) {
            throw new ApplicationException('invalid log config: ' . self::BASEFILENAME_KEY);
        }
        if (!array_key_exists(self::DATE_FORMAT_KEY, $args)) {
            throw new ApplicationException('invalid log config: ' . self::DATE_FORMAT_KEY);
        }
        if (!array_key_exists(self::LOG_LEVEL_KEY, $args)) {
            throw new ApplicationException('invalid log config: ' . self::LOG_LEVEL_KEY);
        }

        return new FileLogger($args[self::DIRECTORY_KEY], $args[self::BASEFILENAME_KEY], $args[self::DATE_FORMAT_KEY], $args[self::LOG_LEVEL_KEY]);
    }
}