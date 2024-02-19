<?php declare(strict_types=1);
namespace Mvc4Wp\System\Controllers;

use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Response\DefaultResponder;
use Mvc4Wp\System\Response\PlainPhpRenderTrait;

abstract class PlainPhpController extends Controller
{
    use Cast, DefaultResponder, PlainPhpRenderTrait;
}