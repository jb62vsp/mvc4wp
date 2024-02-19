<?php declare(strict_types=1);
namespace Mvc4Wp\System\Service;

use Psr\Log\LoggerInterface;
use Mvc4Wp\System\Config\CONFIG;
use Mvc4Wp\System\Config\ConfigInterface;
use Mvc4Wp\System\Logger\LoggerFactoryInterface;
use Mvc4Wp\System\Logger\NullLoggerFactory;

final class Logging
{
    private const DEFAULT_LOGGER_NAME_KEY = 'default_logger_name';

    private const LOGGERS_KEY = 'loggers';

    private const LOGGER_FACTORY_KEY = 'logger_factory';

    private static LoggerInterface $null;

    private static array $loggers;

    private static string $default_logger_name = '';

    public static function configure(ConfigInterface $config): void
    {
        $logconf = $config->get(CONFIG::LOGGER);
        if (array_key_exists(self::DEFAULT_LOGGER_NAME_KEY, $logconf)) {
            self::$default_logger_name = $logconf[self::DEFAULT_LOGGER_NAME_KEY];
        }
        if (array_key_exists(self::LOGGERS_KEY, $logconf)) {
            foreach ($logconf[self::LOGGERS_KEY] as $key => $value) {
                if (array_key_exists(self::LOGGER_FACTORY_KEY, $value) && class_exists($value[self::LOGGER_FACTORY_KEY])) {
                    $factory_class = $value[self::LOGGER_FACTORY_KEY];
                    /** @var LoggerFactoryInterface */
                    $factory = new $factory_class();
                    self::$loggers[$key] = $factory->create($value);
                }
            }
        }
    }

    public static function get(string $logger_name = ''): LoggerInterface
    {
        if (!isset(self::$loggers) || count(self::$loggers) === 0) {
            return self::getNullLogger();
        }

        if (empty($logger_name) && !empty(self::$default_logger_name)) {
            $logger_name = self::$default_logger_name;
        }

        if (array_key_exists(strtolower($logger_name), self::$loggers)) {
            return self::$loggers[strtolower($logger_name)];
        } else {
            return self::getNullLogger();
        }
    }

    private static function getNullLogger(): LoggerInterface
    {
        if (!isset(self::$null) || is_null(self::$null)) {
            /** @var LoggerFactoryInterface */
            $factory = new NullLoggerFactory();
            self::$null = $factory->create();
        }
        return self::$null;
    }
}