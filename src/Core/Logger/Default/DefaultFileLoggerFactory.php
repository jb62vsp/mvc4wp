<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Logger\Default;

use Psr\Log\LoggerInterface;
use Mvc4Wp\Core\Exception\ApplicationException;
use Mvc4Wp\Core\Logger\AbstractLoggerFactory;

class DefaultFileLoggerFactory extends AbstractLoggerFactory
{
    private const DIRECTORY_KEY = 'directory';

    private const BASEFILENAME_KEY = 'basefilename';

    private const FILE_DATE_FORMAT_KEY = 'file_date_format';

    private const DATETIME_FORMAT_KEY = 'datetime_format';

    private const TIMEZONE_KEY = 'timezone';

    private const LOG_LEVEL_KEY = 'log_level';

    public static function create(array $args = []): LoggerInterface
    {
        if (!array_key_exists(self::DIRECTORY_KEY, $args)) {
            throw new ApplicationException('invalid log config: ' . self::DIRECTORY_KEY);
        }
        if (!array_key_exists(self::BASEFILENAME_KEY, $args)) {
            throw new ApplicationException('invalid log config: ' . self::BASEFILENAME_KEY);
        }
        if (!array_key_exists(self::FILE_DATE_FORMAT_KEY, $args)) {
            throw new ApplicationException('invalid log config: ' . self::FILE_DATE_FORMAT_KEY);
        }
        if (!array_key_exists(self::DATETIME_FORMAT_KEY, $args)) {
            throw new ApplicationException('invalid log config: ' . self::DATETIME_FORMAT_KEY);
        }
        if (!array_key_exists(self::TIMEZONE_KEY, $args)) {
            throw new ApplicationException('invalid log config: ' . self::TIMEZONE_KEY);
        }
        if (!array_key_exists(self::LOG_LEVEL_KEY, $args)) {
            throw new ApplicationException('invalid log config: ' . self::LOG_LEVEL_KEY);
        }

        return new DefaultFileLogger(
            $args[self::DIRECTORY_KEY],
            $args[self::BASEFILENAME_KEY],
            $args[self::FILE_DATE_FORMAT_KEY],
            $args[self::DATETIME_FORMAT_KEY],
            $args[self::TIMEZONE_KEY],
            strtolower($args[self::LOG_LEVEL_KEY]),
        );
    }
}