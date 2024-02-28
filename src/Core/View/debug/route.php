<?php declare(strict_types=1); ?>
<?php global $mvc4wp_debug; ?>
<div class='expand-containers'>
    <?php if (array_key_exists('route', $mvc4wp_debug) && !empty($mvc4wp_debug['route'])): ?>
        <?php $route = $mvc4wp_debug['route'][0]; ?>
        <h5 class='cyan'>
            <?php eh(sprintf("%s: %s", $route['method'], $route['uri'])); ?>
        </h5>
        <h5 class='green'>
            <?php eh(sprintf("=> %s", $route['route']->signature)); ?>
        </h5>
        <div class='green'>
            <pre class='green'><?php eh(var_export($route['route']->args, true)); ?></pre>
        </div>
        <div class='expand-container'>
            <input type='checkbox' id='debug-route-routes-toggle' class='checkbox'>
            <label for='debug-route-routes-toggle' class='label clickable'>
                <h4><i class="icon-plus"></i>ALL Routes</h4>
            </label>
            <div class='expandable'>
                <?php foreach ($route['routes'] as $k => $v): ?>
                    <p class='green'>
                        <?php eh(implode(': ', explode('`', $k)) . ' => ' . $v); ?>
                    </p>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>