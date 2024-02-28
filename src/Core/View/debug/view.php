<?php declare(strict_types=1); ?>
<?php global $mvc4wp_debug; ?>
<div class='expand-containers'>
    <?php foreach ($mvc4wp_debug['view'] as $i => $view): ?>
        <div class='expand-container'>
            <input type='checkbox' id='debug-view-<?php echo $i; ?>-toggle' class='checkbox'>
            <label for='debug-view-<?php echo $i; ?>-toggle' class='label clickable'>
                <h4><i class="icon-plus"></i>
                    <?php eh($view[('name')]); ?>
                </h4>
            </label>
            <div class='expandable'>
                <p>
                    <span class='cyan'>duration</span> =&gt; <span class='green'>
                        <?php eh(sprintf("%.4f", $view['duration'])); ?>ms
                    </span>
                </p>
                <p>
                    <span class='cyan'>data</span> =&gt; <span>
                        <pre class='green'><?php eh(var_export($view['data'], true)); ?></pre>
                    </span>
                </p>
            </div>
        </div>
    <?php endforeach; ?>
</div>