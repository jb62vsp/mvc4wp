<?php declare(strict_types=1);
namespace System\Controllers;

use System\Core\Cast;
use System\Response\HtmlRenderTrait;

abstract class HtmlController extends Controller
{
    use Cast, HtmlRenderTrait;
}