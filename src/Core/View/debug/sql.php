<?php declare(strict_types=1); ?>
<?php global $mvc4wp_debug; ?>
<div>
    <?php foreach ($mvc4wp_debug['sql'] as $sql): ?>
        <p>
            <span class='green'>
                <?php eh($sql['sql']); ?>
            </span>
        </p>
    <?php endforeach; ?>
</div>