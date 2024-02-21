<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Exception;

use Exception;
use Mvc4Wp\Core\Library\Castable;

class ApplicationException extends Exception
{
    use Castable;
}