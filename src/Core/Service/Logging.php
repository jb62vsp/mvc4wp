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
        $logger_config = $config->get('logger');
        if (array_key_exists('default_logger_name', $logger_config)) {
            self::$default_logger_name = $logger_config['default_logger_name'];
        }
        if (array_key_exists('loggers', $logger_config)) {
            foreach ($logger_config['loggers'] as $logger_name => $logger) {
                if (array_key_exists('logger_factory', $logger) && class_exists($logger['logger_factory'])) {
                    /** @var LoggerFactoryInterface $logger_factory */
                    $logger_factory = $logger['logger_factory'];
                    self::$loggers[$logger_name] = $logger_factory::create($logger);
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
            self::$null = NullLoggerFactory::create();
        }
        return self::$null;
    }
}