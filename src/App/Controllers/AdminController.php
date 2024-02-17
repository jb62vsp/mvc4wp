<?php declare(strict_types=1);
namespace App\Controllers;

use System\Controllers\PlainPhpController;
use System\Core\Cast;

abstract class AdminController extends PlainPhpController
{
    use Cast;

    public function init(array $args = []): void
    {
        if (!is_user_logged_in()) {
            $this->notFound()->done();
        }
    }
}