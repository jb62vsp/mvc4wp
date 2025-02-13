<?php

declare(strict_types=1);

namespace Mvc4Wp\Core\Controller;

use Mvc4Wp\Core\Library\Castable;

class SassRenderer implements RenderInterface
{
    use Castable, SassRenderable;

    public function __construct(bool $with_tag = true)
    {
        $this->with_tag = $with_tag;
    }
}
