<?php declare(strict_types=1);
namespace App\Controller;

use Mvc4Wp\Core\Controller\PlainPhpController;
use Mvc4Wp\Core\Library\Castable;

class ErrorController extends PlainPhpController
{
    use Castable;

    public function init(array $args = []): void
    {
    }

    public function index(array $args = []): void
    {
        echo 'error';
    }
}