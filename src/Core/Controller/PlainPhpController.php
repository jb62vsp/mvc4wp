<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use Mvc4Wp\Core\Library\Cast;

abstract class PlainPhpController extends Controller
{
    use Cast, HttpResponder, PlainPhpRenderTrait;
}