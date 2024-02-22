<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library;

interface ClockFactoryInterface
{
    public function create(array $args = []): ClockInterface;
}