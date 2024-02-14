<?php declare(strict_types=1);
namespace System\Controllers;

use System\Core\Cast;
use System\Response\JsonRenderTrait;

abstract class JsonController extends Controller
{
    use Cast, JsonRenderTrait;
}