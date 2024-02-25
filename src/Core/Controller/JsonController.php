<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use Mvc4Wp\Core\Library\Castable;

abstract class JsonController extends Controller
{
    use Castable, HttpRespondable, JsonRenderable;
}