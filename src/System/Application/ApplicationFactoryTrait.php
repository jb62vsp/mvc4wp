<?php declare(strict_types=1);
namespace Wp4Mvc\System\Application;

trait ApplicationFactoryTrait
{
    abstract public function create(array $args = []): ApplicationInterface;
}