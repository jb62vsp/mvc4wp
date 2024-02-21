<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Service;

class Helper
{
    public static function load(string $helper_name): void
    {
        $app_helper = App::get()->config()->get('APP_ROOT') . '/Helper/' . ucfirst($helper_name) . 'Helper.php';
        if (file_exists($app_helper)) {
            include_once($app_helper);
        }

        $system_helper = App::get()->config()->get('CORE_ROOT') . '/Helper/' . ucfirst($helper_name) . 'Helper.php';
        if (file_exists($system_helper)) {
            include_once($system_helper);
        }
    }
}