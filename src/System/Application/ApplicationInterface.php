<?php declare(strict_types=1);
namespace Mvc4Wp\System\Application;

use Mvc4Wp\System\Config\ConfiguratorInterface;
use Mvc4Wp\System\Controller\ControllerInterface;
use Mvc4Wp\System\Route\RouterInterface;

interface ApplicationInterface
{
    public function config(): ConfiguratorInterface;

    public function router(): RouterInterface;

    public function controller(): ControllerInterface;
    
    public function run(): void;
}