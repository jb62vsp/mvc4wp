<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use Mvc4Wp\Core\Library\Cast;

abstract class JsonController extends Controller
{
    use Cast, HttpResponder, JsonRenderTrait;
}