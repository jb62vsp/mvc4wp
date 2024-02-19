<?php declare(strict_types=1);
namespace Mvc4Wp\System\Service;

use Mvc4Wp\System\Controller\Controller;

final class Locator
{
    private static $controller;
    
    public static function setController(Controller $controller): void
    {
        self::$controller = $controller;
    }

    public static function getController(): Controller
    {
        return self::$controller;
    }
}