<?php

declare(strict_types=1); ?>
<?php global $mvc4wp_debug; ?>
<div class='expand-containers'>
    <?php if (array_key_exists('timer', $mvc4wp_debug) && !empty($mvc4wp_debug['timer'])): ?>
        <?php foreach ($mvc4wp_debug['timer'] as $i => $timer): ?>
            <p>
                <span class='name debug-cyan'>
                    <?php eh($timer['name']); ?>
                </span>
                <span class='value debug-green'>
                    <?php eh(sprintf("%.4fms", $timer['duration'])); ?>
                </span>
            </p>
        <?php endforeach; ?>
    <?php endif; ?>
</div>