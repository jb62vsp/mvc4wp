<?php declare(strict_types=1);
namespace Mvc4Wp\System\Route;

use Mvc4Wp\System\Library\Cast;
use Mvc4Wp\System\Library\HttpStatus;
use Mvc4Wp\System\Exception\ApplicationException;

final class RouteHandler
{
    use Cast;

    private const DELIMITER = '::';

    public string $class = '';

    public string $method = '';

    public function __construct(
        public HttpStatus $status,
        public string $signature = '',
        public array $args = [],
    ) {
        if (!empty($signature)) {
            $signatures = explode(self::DELIMITER, $signature);
            if (count($signatures) !== 2) {
                throw new ApplicationException('illegal to set signature.');
            }
            $this->class = $signatures[0];
            $this->method = $signatures[1];
        }
    }
}