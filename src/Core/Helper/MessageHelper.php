<?php declare(strict_types=1);

use Mvc4Wp\Core\Service\App;

if (!function_exists('msg')) {
    function msg(string $message_key, array $args = []): string
    {
        return App::get()->messager()->message($message_key, $args);
    }
}