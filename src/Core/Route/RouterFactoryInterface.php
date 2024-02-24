<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Route;

interface RouterFactoryInterface
{
    public static function create(array $args = []);
}