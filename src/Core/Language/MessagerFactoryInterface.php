<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library;

interface MessagerFactoryInterface
{
    public static function create(array $args = []): MessagerInterface;
}