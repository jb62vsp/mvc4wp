<?php declare(strict_types=1);
namespace Wp4Mvc\System\Route;

use Wp4Mvc\System\Core\Cast;
use Wp4Mvc\System\Core\HttpStatus;
use Wp4Mvc\System\Exception\ApplicationException;

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