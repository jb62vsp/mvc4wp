<?php declare(strict_types=1); ?>
<?php global $mvc4wp_debug; ?>
<div>
    <?php if (array_key_exists('error', $mvc4wp_debug) && !empty($mvc4wp_debug['error'])): ?>
        <pre class='red'><?php eh(print_r($mvc4wp_debug['error'][0]['exception'], true)); ?></pre>
    <?php endif; ?>
</div>