<?php

declare(strict_types=1); ?>
<?php global $mvc4wp_debug; ?>
<div class='expand-container'>
    <?php if (array_key_exists('error', $mvc4wp_debug) && !empty($mvc4wp_debug['error'])): ?>
        <?php $ex = $mvc4wp_debug['error'][0]['exception']; ?>
        <p>
            <span class='name debug-cyan'>Exception</span>
            <span class='value debug-red'>
                <?php eh(get_class($ex)); ?>
            </span>
        </p>
        <p>
            <span class='name debug-cyan'>Message</span>
            <span class='value debug-red'>
                <?php eh($ex->getMessage()); ?>
            </span>
        </p>
        <p>
            <span class='name debug-cyan'>Code</span>
            <span class='value debug-red'>
                <?php eh($ex->getCode()); ?>
            </span>
        </p>
        <p>
            <span class='name debug-cyan'>Line</span>
            <span class='value debug-red'>
                <?php eh($ex->getFile() . ':' . $ex->getLine()); ?>
            </span>
        </p>
        <?php $traces = $mvc4wp_debug['error'][0]['exception']->getTrace(); ?>
        <?php for ($i = 0, $il = count($traces); $i < $il; $i++): ?>
            <input type='checkbox' id='debug-error-trace-toggle-<?php eh($i); ?>' class='checkbox'>
            <label for='debug-error-trace-toggle-<?php eh($i); ?>' class='label debug-clickable'>
                <h4><i class="icon-plus"></i><?php eh("{$traces[$i]['file']}:{$traces[$i]['line']}"); ?></h4>
            </label>
            <div class='expandable'>
                <pre class='debug-green'><?php eh(print_r($traces[$i], true)); ?></pre>
            </div>
        <?php endfor; ?>
    <?php endif; ?>
</div>