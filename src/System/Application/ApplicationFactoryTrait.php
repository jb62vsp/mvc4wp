<?php declare(strict_types=1);
namespace Mvc4Wp\System\Application;

trait ApplicationFactoryTrait
{
    abstract public function create(array $args = []): ApplicationInterface;
}