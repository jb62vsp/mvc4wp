<?php declare(strict_types=1);
namespace Wp4Mvc\System\Application;

interface ApplicationFactoryInterface
{
    public function create(): ApplicationInterface;
}