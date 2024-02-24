<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Service;

use Psr\Log\LoggerInterface;
use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Logger\LoggerFactoryInterface;
use Mvc4Wp\Core\Logger\NullLoggerFactory;

final class Logging
{
    private static LoggerInterface $null;

    private static array $loggers;

    private static string $default_logger_name = '';

    public static function configure(ConfiguratorInterface $config): void
    {
        $logconf = $config->get('logger');
        if (array_key_exists('default_logger_name', $logconf)) {
            self::$default_logger_name = $logconf['default_logger_name'];
        }
        if (array_key_exists('loggers', $logconf)) {
            foreach ($logconf['loggers'] as $key => $value) {
                if (array_key_exists('logger_factory', $value) && class_exists($value['logger_factory'])) {
                    $factory_class = $value['logger_factory'];
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
            $factory = new NullLoggerFactory();
            self::$null = $factory->create();
        }
        return self::$null;
    }
}