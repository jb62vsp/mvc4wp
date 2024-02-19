<?php declare(strict_types=1);
namespace App\Controller;

use Mvc4Wp\System\Controller\PlainPhpController;
use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Service\Logging;

abstract class AdminController extends PlainPhpController
{
    use Cast;

    public function init(array $args = []): void
    {
        if (!is_user_logged_in()) {
            Logging::get()->notice('Not logged in user access to ' . $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'] . ' => ' . static::class . ', from: ' . $_SERVER['REMOTE_ADDR']);
            $this->notFound()->done();
        }
    }
}