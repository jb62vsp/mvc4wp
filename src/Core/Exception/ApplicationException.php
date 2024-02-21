<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Exception;

use Exception;
use Mvc4Wp\Core\Library\Cast;

class ApplicationException extends Exception
{
    use Cast;
}