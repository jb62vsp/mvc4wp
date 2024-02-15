<?php declare(strict_types=1);
namespace System\Application;

use System\Config\CONFIG;
use System\Config\ConfigInterface;
use System\Config\ConfigTrait;
use System\Route\RouterInterface;
use System\Route\RouterTrait;

final class Application implements ApplicationInterface, ConfigInterface, RouterInterface
{
    use ApplicationTrait, ConfigTrait, RouterTrait;

    public function __construct()
    {
        /*
         * -------- DEFAULT CONFIGURATIONS --------
         */
        $this->addConfig(CONFIG::DEBUG, 'false');
        $this->addConfig(CONFIG::BOOTSTRAP, __WPMVC_ROOT__ . '/src/App/bootstrap.php');
        $this->addConfig(CONFIG::CONTROLLER_NAMESPACE, 'App\Controllers');
        $this->addConfig(CONFIG::VIEW_DIRECTORY, __WPMVC_ROOT__ . '/src/App/Views/');
    }

    public function run(): void
    {
        $this->execute($this->config(), $this->router());
    }
}