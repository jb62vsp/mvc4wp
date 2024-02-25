<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller\Default;

use Mvc4Wp\Core\Controller\ErrorController;
use Mvc4Wp\Core\Controller\HttpRespondable;
use Mvc4Wp\Core\Controller\PlainPhpRenderable;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Library\HttpStatus;

class DefaultErrorController extends ErrorController
{
    use Castable, HttpRespondable, PlainPhpRenderable;

    public function init(array $args = []): void
    {
    }

    public function index(array $args = []): void
    {
        if (empty($args)) {
            $this->response(HttpStatus::INTERNAL_SERVER_ERROR, true)->done();
        }

        if ($args[0] instanceof HttpStatus) {
            $this->response($args[0], true)->done();
        }

        if (is_int($args[0]) && HttpStatus::tryFrom($args[0])) {
            $this->response($args[0], true)->done();
        }

        $this->response(HttpStatus::INTERNAL_SERVER_ERROR, true)->done();
    }
}