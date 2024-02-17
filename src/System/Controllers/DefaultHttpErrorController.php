<?php declare(strict_types=1);
namespace System\Controllers;

use System\Config\ConfigInterface;
use System\Core\Cast;
use System\Core\HttpStatus;
use System\Response\DefaultResponder;
use System\Response\PlainPhpRenderTrait;

class DefaultHttpErrorController extends Controller
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