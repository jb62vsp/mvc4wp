<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library;

interface MessagerInterface
{
    public function message(string $message_key, array $args = []): string|false;
}