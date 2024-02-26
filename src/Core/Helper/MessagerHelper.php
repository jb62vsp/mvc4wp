<?php declare(strict_types=1);

use Mvc4Wp\Core\Service\App;

if (!function_exists('message_format')) {
    function message_format(string $message, array $args = []): void
    {
        App::get()->messager()->format($message, $args);
    }
}