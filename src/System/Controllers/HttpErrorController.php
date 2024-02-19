<?php declare(strict_types=1);
namespace Mvc4Wp\System\Controllers;

use Mvc4Wp\System\Config\ConfigInterface;
use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Core\HttpStatus;
use Mvc4Wp\System\Response\DefaultResponder;
use Mvc4Wp\System\Response\PlainPhpRenderTrait;

class HttpErrorController extends Controller
{
    use Cast, DefaultResponder, PlainPhpRenderTrait;

    public function __construct(
        public ConfigInterface $config,
        public HttpStatus $httpStatus,
    ) {
        parent::__construct($config);
    }

    public function init(array $args = []): void
    {
    }

    public function index(array $args = []): void
    {
        $this->response($this->httpStatus, true);
        $this->done();
    }
}