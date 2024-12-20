<?php declare(strict_types=1); ?>
<?php global $mvc4wp_debug; ?>
<div class='expand-containers'>
    <?php if (array_key_exists('query', $mvc4wp_debug) && !empty($mvc4wp_debug['query'])): ?>
        <?php foreach ($mvc4wp_debug['query'] as $i => $query): ?>
            <div class='expand-container'>
                <input type='checkbox' id='debug-query-<?php echo $i; ?>-toggle' class='checkbox'>
                <label for='debug-query-<?php echo $i; ?>-toggle' class='label clickable'>
                    <h4><i class="icon-plus"></i>
                        <?php eh($query['executor']); ?>
                    </h4>
                </label>
                <div class='expandable'>
                    <p>
                        <span class='name cyan'>caller</span>
                        <span class='value green'>
                            <?php eh($query['caller']); ?>
                        </span>
                    </p>
                    <p>
                        <span class='name cyan'>duration</span>
                        <span class='value green'>
                            <?php eh(sprintf("%.4fms", $query['duration'])); ?>
                        </span>
                    </p>
                    <p>
                        <span class='name cyan'>query</span>
                        <span class='value'>
                            <pre class='block green'><?php eh(print_r($query['query'], true)); ?></pre>
                        </span>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>