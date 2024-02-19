<?php declare(strict_types=1);
namespace Wp4Mvc\System\Application;

use Wp4Mvc\System\Config\ConfigInterface;
use Wp4Mvc\System\Route\RouterInterface;

interface ApplicationInterface
{
    public function config(): ConfigInterface;

    public function router(): RouterInterface;
    
    public function run(): void;
}