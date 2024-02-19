<?php declare(strict_types=1);
namespace Wp4Mvc\System\Service;

use Wp4Mvc\System\Controllers\Controller;

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