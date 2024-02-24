<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Service;

class Helper
{
    public static function load(string $helper_name): void
    {
        $app_helper = App::get()->config()->get('app_root') . '/Helper/' . ucfirst($helper_name) . 'Helper.php';
        if (file_exists($app_helper)) {
            include_once($app_helper);
        }

        $core_helper = App::get()->config()->get('core_root') . '/Helper/' . ucfirst($helper_name) . 'Helper.php';
        if (file_exists($core_helper)) {
            include_once($core_helper);
        }
    }
}