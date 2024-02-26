<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Language;

interface MessagerFactoryInterface
{
    public static function create(array $args = []): MessagerInterface;
}