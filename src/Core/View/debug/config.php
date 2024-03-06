<?php declare(strict_types=1); ?>
<?php use Mvc4Wp\Core\Service\App; ?>
<div class='expand-containers'>
    <?php foreach (App::get()->config()->getAll() as $i => $config): ?>
        <div class='expand-container'>
            <input type='checkbox' id='debug-config-<?php echo $i; ?>-toggle' class='checkbox'>
            <label for='debug-config-<?php echo $i; ?>-toggle' class='label clickable'>
                <h4>
                    <i class="icon-plus"></i>
                    <?php eh($i); ?>
                </h4>
            </label>
            <div class='expandable'>
                <pre class='green'><?php eh(print_r($config, true)); ?></pre>
            </div>
        </div>
    <?php endforeach; ?>
</div>