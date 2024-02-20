<?php declare(strict_types=1);
namespace Mvc4Wp\System\Exception;

use Exception;
use Mvc4Wp\System\Core\Cast;

class ApplicationException extends Exception
{
    use Cast;
}