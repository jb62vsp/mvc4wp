<?php declare(strict_types=1);
namespace System\Route;

interface RouterFactoryInterface
{
    public function create(array $args = []);
}