<?php declare(strict_types=1);
namespace Mvc4Wp\System\Controller;

use Mvc4Wp\System\Config\ConfiguratorInterface;
use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Core\HttpStatus;

class HttpErrorController extends Controller
{
    use Cast, HttpResponder, PlainPhpRenderTrait;

    public function __construct(
        public ConfiguratorInterface $config,
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