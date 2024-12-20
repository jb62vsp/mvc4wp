<?php declare(strict_types=1);
use Mvc4Wp\Core\Library\Debug\DebugScssRenderer;
use Mvc4Wp\Core\Service\App;

?>
<style id='debug_style'>
    <?php
    $renderer = new DebugScssRenderer();
    $renderer->render(App::get()->config(), $renderer, 'debug');
    ?>
</style>