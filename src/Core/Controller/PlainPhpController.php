<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use Mvc4Wp\Core\Library\Castable;

abstract class PlainPhpController extends Controller
{
    use Castable, HttpResponder, PlainPhpRenderTrait;
}