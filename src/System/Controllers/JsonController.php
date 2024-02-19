<?php declare(strict_types=1);
namespace Wp4Mvc\System\Controllers;

use Wp4Mvc\System\Core\Cast;
use Wp4Mvc\System\Response\JsonRenderTrait;

abstract class JsonController extends Controller
{
    use Cast, JsonRenderTrait;
}