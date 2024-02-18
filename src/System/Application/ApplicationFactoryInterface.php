<?php declare(strict_types=1);
namespace System\Application;

interface ApplicationFactoryInterface
{
    public function create(): ApplicationInterface;
}