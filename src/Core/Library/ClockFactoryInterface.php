<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library;

interface ClockFactoryInterface
{
    public static function create(array $args = []): ClockInterface;
}