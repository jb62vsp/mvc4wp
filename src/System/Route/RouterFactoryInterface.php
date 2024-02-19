<?php declare(strict_types=1);
namespace Mvc4Wp\System\Route;

interface RouterFactoryInterface
{
    public function create(array $args = []);
}