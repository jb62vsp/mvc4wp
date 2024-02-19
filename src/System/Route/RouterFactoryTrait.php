<?php declare(strict_types=1);
namespace Wp4Mvc\System\Route;

trait RouterFactoryTrait
{
    abstract public function create(array $args = []);
}