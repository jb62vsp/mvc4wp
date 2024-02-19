<?php declare(strict_types=1);
namespace Mvc4Wp\System\Controllers;

use Mvc4Wp\System\Core\Cast;

abstract class PlainPhpController extends Controller
{
    use Cast, HttpResponder, PlainPhpRenderTrait;
}