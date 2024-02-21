<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Application;

use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Controller\ControllerInterface;
use Mvc4Wp\Core\Route\RouterInterface;

interface ApplicationInterface
{
    public function config(): ConfiguratorInterface;

    public function router(): RouterInterface;

    public function controller(): ControllerInterface;
    
    public function run(): void;
}