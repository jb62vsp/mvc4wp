<?php declare(strict_types=1);
namespace System\Application;

trait ApplicationFactoryTrait
{
    abstract public function create(array $args = []): ApplicationInterface;
}