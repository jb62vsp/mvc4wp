<?php declare(strict_types=1);
namespace Mvc4Wp\System\Controller;

use Mvc4Wp\System\Library\Cast;

abstract class PlainPhpController extends Controller
{
    use Cast, HttpResponder, PlainPhpRenderTrait;
}