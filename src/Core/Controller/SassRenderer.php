<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use Mvc4Wp\Core\Library\Castable;

class SassRenderer implements RenderInterface
{
    use Castable, SassRenderable;
}