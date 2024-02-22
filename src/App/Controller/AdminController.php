<?php declare(strict_types=1);
namespace App\Controller;

use Mvc4Wp\Core\Controller\PlainPhpController;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Service\Logging;

abstract class AdminController extends PlainPhpController
{
    use Castable;

    public function init(array $args = []): void
    {
        if (!is_user_logged_in()) {
            Logging::get()->notice('Not logged in user access to ' . $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'] . ' => ' . static::class . ', from: ' . $_SERVER['REMOTE_ADDR']);
            $this->notFound()->done();
        }
    }
}