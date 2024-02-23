<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Exception;

use Mvc4Wp\Core\Library\Castable;

class QueryBuildViolationException extends ApplicationException
{
    use Castable;
}