<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use Mvc4Wp\Core\Library\Castable;

class ScssRenderer implements RenderInterface
{
    use Castable, ScssRenderable;
}