<?php declare(strict_types=1);
namespace System\Service;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use System\Config\CONFIG;
use System\Config\ConfigInterface;

final class Logging
{
    private static LoggerInterface $null;

    private static LoggerInterface $logger;

    public static function configure(ConfigInterface $config): void
    {
        $cls = $config->get(CONFIG::LOGGER);
        self::$logger = new $cls($config);
    }

    public static function get(): LoggerInterface
    {
        if (isset(self::$logger)) {
            return self::$logger;
        } else {
            return self::getNullLogger();
        }
    }

    private static function getNullLogger(): LoggerInterface
    {
        if (!isset(self::$null) || is_null(self::$null)) {
            self::$null = new NullLogger();
        }
        return self::$null;
    }
}