<?php declare(strict_types=1); ?>
<?php global $mvc4wp_debug; ?>
<div>
    <?php if (array_key_exists('sql', $mvc4wp_debug) && !empty($mvc4wp_debug['sql'])): ?>
        <?php foreach ($mvc4wp_debug['sql'] as $sql): ?>
            <p>
                <?php eh($sql['sql']); ?>
            </p>
        <?php endforeach; ?>
    <?php endif; ?>
</div>