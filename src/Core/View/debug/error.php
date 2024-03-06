<?php declare(strict_types=1); ?>
<?php global $mvc4wp_debug; ?>
<div class='expand-container'>
    <?php if (array_key_exists('error', $mvc4wp_debug) && !empty($mvc4wp_debug['error'])): ?>
        <?php $ex = $mvc4wp_debug['error'][0]['exception']; ?>
        <h3>Exception</h3>
        <p>
            <span class='name cyan'>Exception</span>
            <span class='value red'>
                <?php eh(get_class($ex)); ?>
            </span>
        </p>
        <p>
            <span class='name cyan'>Message</span>
            <span class='value red'>
                <?php eh($ex->getMessage()); ?>
            </span>
        </p>
        <p>
            <span class='name cyan'>Code</span>
            <span class='value red'>
                <?php eh($ex->getCode()); ?>
            </span>
        </p>
        <p>
            <span class='name cyan'>File</span>
            <span class='value red'>
                <?php eh($ex->getFile()); ?>
            </span>
        </p>
        <p>
            <span class='name cyan'>Line</span>
            <span class='value red'>
                <?php eh($ex->getLine()); ?>
            </span>
        </p>
        <input type='checkbox' id='debug-error-trace-toggle' class='checkbox'>
        <label for='debug-error-trace-toggle' class='label clickable'>
            <h4><i class="icon-plus"></i>Stack Trace</h4>
        </label>
        <div class='expandable'>
            <?php foreach ($mvc4wp_debug['error'][0]['exception']->getTrace() as $ex): ?>
                <pre class='green'><?php eh(print_r($ex, true)); ?></pre>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>