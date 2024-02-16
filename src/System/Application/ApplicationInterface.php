<?php declare(strict_types=1);
namespace System\Application;

use System\Config\ConfigInterface;
use System\Route\RouterInterface;

interface ApplicationInterface
{
    public function config(): ConfigInterface;

    public function router(): RouterInterface;
    
    public function run(): void;
}