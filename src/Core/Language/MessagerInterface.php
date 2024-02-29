<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Language;

interface MessagerInterface
{
    public function message(string $message_key, array $args = []): string;
}