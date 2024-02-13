<?php declare(strict_types=1);
namespace System\Application;

use System\Config\ConfigInterface;
use System\Route\RouterInterface;

interface ApplicationInterface
{
    public function execute(ConfigInterface $config, RouterInterface $router): void;
}