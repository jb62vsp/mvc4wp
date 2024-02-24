<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Service;

use Mvc4Wp\Core\Application\ApplicationFactoryInterface;
use Mvc4Wp\Core\Application\ApplicationInterface;
use Mvc4Wp\Core\Application\Default\DefaultApplicationFactory;

final class App
{
    private static ApplicationInterface $application;

    /**
     * @param class-string<ApplicationFactoryInterface> $application_factory
     */
    public static function set(string $application_factory): void
    {
        if (class_exists($application_factory)) {
            self::$application = $application_factory::create();
        }
    }

    public static function get(): ApplicationInterface
    {
        if (isset(self::$application)) {
            return self::$application;
        } else {
            self::$application = DefaultApplicationFactory::create();
            return self::$application;
        }
    }
}