<?php declare(strict_types=1);
namespace Mvc4Wp\System\Controller;

use Mvc4Wp\System\Library\Cast;

abstract class JsonController extends Controller
{
    use Cast, HttpResponder, JsonRenderTrait;
}