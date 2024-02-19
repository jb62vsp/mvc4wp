<?php declare(strict_types=1);
namespace Wp4Mvc\System\Controllers;

use Wp4Mvc\System\Core\Cast;
use Wp4Mvc\System\Response\DefaultResponder;
use Wp4Mvc\System\Response\PlainPhpRenderTrait;

abstract class PlainPhpController extends Controller
{
    use Cast, DefaultResponder, PlainPhpRenderTrait;
}