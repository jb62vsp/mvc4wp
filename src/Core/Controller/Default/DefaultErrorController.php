<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller\Default;

use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Controller\ErrorController;
use Mvc4Wp\Core\Controller\HttpResponder;
use Mvc4Wp\Core\Controller\PlainPhpRenderTrait;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Library\HttpStatus;

class DefaultErrorController extends ErrorController
{
    use Castable, HttpResponder, PlainPhpRenderTrait;

    public function __construct(
        public ConfiguratorInterface $config,
    ) {
        parent::__construct($config);
    }

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
        } elseif (is_int($args[0]) && HttpStatus::tryFrom($args[0])) {
            $this->response($args[0], true)->done();
        } else {
            $this->response(HttpStatus::INTERNAL_SERVER_ERROR, true)->done();
        }
    }
}