<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library;

use Stringable;

interface MessagerInterface
{
    public function format(string|Stringable $message, array $args = []): string|false;
}