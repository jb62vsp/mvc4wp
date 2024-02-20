<?php declare(strict_types=1);
namespace Mvc4Wp\System\Service;

use Mvc4Wp\System\Application\ApplicationFactoryInterface;
use Mvc4Wp\System\Application\ApplicationInterface;
use Mvc4Wp\System\Application\Default\DefaultApplicationFactory;

final class App
{
    private static ApplicationInterface $application;

    public static function set(ApplicationFactoryInterface $factory): void
    {
        self::$application = $factory->create();
    }

    public static function get(): ApplicationInterface
    {
        if (isset(self::$application)) {
            return self::$application;
        } else {
            $factory = new DefaultApplicationFactory();
            self::$application = $factory->create();
            return self::$application;
        }
    }
}