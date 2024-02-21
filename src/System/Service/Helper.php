<?php declare(strict_types=1);
namespace Mvc4Wp\System\Service;

class Helper
{
    public static function use (string $helper_name): void
    {
        $app_helper = App::get()->config()->get('APP_ROOT') . '/Helper/' . ucfirst($helper_name) . 'Helper.php';
        if (file_exists($app_helper)) {
            include_once($app_helper);
        }

        $system_helper = App::get()->config()->get('SYSTEM_ROOT') . '/Helper/' . ucfirst($helper_name) . 'Helper.php';
        if (file_exists($system_helper)) {
            include_once($system_helper);
        }
    }
}