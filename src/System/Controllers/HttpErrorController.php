<?php declare(strict_types=1);
namespace Wp4Mvc\System\Controllers;

use Wp4Mvc\System\Config\ConfigInterface;
use Wp4Mvc\System\Core\Cast;
use Wp4Mvc\System\Core\HttpStatus;
use Wp4Mvc\System\Response\DefaultResponder;
use Wp4Mvc\System\Response\PlainPhpRenderTrait;

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