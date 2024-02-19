<?php declare(strict_types=1);
namespace Mvc4Wp\System\Route;

trait RouterFactoryTrait
{
    abstract public function create(array $args = []);
}