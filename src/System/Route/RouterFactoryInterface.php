<?php declare(strict_types=1);
namespace Wp4Mvc\System\Route;

interface RouterFactoryInterface
{
    public function create(array $args = []);
}