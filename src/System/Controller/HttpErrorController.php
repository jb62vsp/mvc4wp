<?php declare(strict_types=1);
namespace Mvc4Wp\System\Controller;

use Mvc4Wp\System\Config\ConfigInterface;
use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Core\HttpStatus;

class HttpErrorController extends Controller
{
    use Cast, HttpResponder, PlainPhpRenderTrait;

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