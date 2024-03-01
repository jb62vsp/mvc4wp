<?php declare(strict_types=1);

use Mvc4Wp\Core\Service\App;

if (!function_exists('message_key')) {
    function message_key(string $message_key, array $args = []): string
    {
        return App::get()->messager()->message($message_key, $args);
    }
}

if (!function_exists('message')) {
    function message(string $message, array $args = []): string
    {
        return App::get()->messager()->message('', $args, $message);
    }
}