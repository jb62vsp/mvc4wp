<?php declare(strict_types=1);
namespace Mvc4Wp\System\Service;

use Mvc4Wp\System\Application\ApplicationFactoryInterface;
use Mvc4Wp\System\Application\ApplicationInterface;
use Mvc4Wp\System\Application\Default\DefaultApplicationFactory;
use Mvc4Wp\System\Exception\ApplicationException;

final class App
{
    private const DEFAULT_NAME = '';

    private static array $applications = [];

    public static function add(string $application_name, ApplicationFactoryInterface $factory): void
    {
        self::$applications[$application_name] = $factory->create();
    }

    public static function get(string $application_name = self::DEFAULT_NAME): ApplicationInterface
    {
        if (empty($application_name)) {
            return self::getDefaultApplication();
        } elseif (array_key_exists($application_name, self::$applications)) {
            return self::$applications[$application_name];
        } else {
            throw new ApplicationException('application not found, ' . $application_name);
        }
    }

    private static function getDefaultApplication(): ApplicationInterface
    {
        if (count(self::$applications) === 0) {
            $factory = new DefaultApplicationFactory();
            $application = $factory->create();
            self::$applications[self::DEFAULT_NAME] = $application;
        }
        return self::$applications[self::DEFAULT_NAME];
    }
}