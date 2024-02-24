<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Application;

interface ApplicationFactoryInterface
{
    public static function create(array $args = []): ApplicationInterface;
}