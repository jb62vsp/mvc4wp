<?php declare(strict_types=1);
namespace System\Route;

trait RouterFactoryTrait
{
    abstract public function create(array $args = []);
}