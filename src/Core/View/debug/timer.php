<?php declare(strict_types=1); ?>
<?php global $mvc4wp_debug; ?>
<div class='expand-containers'>
    <?php if (array_key_exists('timer', $mvc4wp_debug) && !empty($mvc4wp_debug['timer'])): ?>
        <?php foreach ($mvc4wp_debug['timer'] as $i => $timer): ?>
            <div class='expand-container'>
                <input type='checkbox' id='debug-timer-<?php echo $i; ?>-toggle' class='checkbox'>
                <label for='debug-timer-<?php echo $i; ?>-toggle' class='label clickable'>
                    <h4><i class="icon-plus"></i>
                        <?php eh($timer['name']); ?>
                    </h4>
                </label>
                <div class='expandable'>
                    <p>
                        <span class='name cyan'>duration</span>
                        <span class='value green'>
                            <?php eh(sprintf("%.4fms", $timer['duration'])); ?>
                        </span>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>