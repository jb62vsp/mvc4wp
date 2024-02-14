<?php declare(strict_types=1);
namespace System\Controllers;

use System\Core\Cast;
use System\Response\PlainPhpRenderTrait;

abstract class PlainPhpController extends Controller
{
    use Cast, PlainPhpRenderTrait;
}