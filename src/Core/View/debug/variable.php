<?php

declare(strict_types=1);

use Mvc4Wp\Core\Service\App;

global $mvc4wp_debug;
$g = [
    'get' => $_GET,
    'post' => $_POST,
    'cookie' => $_COOKIE,
    'files' => $_FILES,
    'env' => $_ENV,
    'request' => $_REQUEST,
    'server' => $_SERVER,
]; ?>
<?php if (!App::get()->config()->get('debug.variable.disable') || !in_array('named', App::get()->config()->get('debug.variable.disable'))): ?>
    <div class='expand-container'>
        <input type='checkbox' id='debug-variable-named-toggle' class='checkbox'>
        <label for='debug-variable-named-toggle' class='label debug-clickable'>
            <h4><i class="icon-plus"></i>Named variables</h4>
        </label>
        <div class='expandable'>
            <?php if (array_key_exists('var', $mvc4wp_debug) && !empty($mvc4wp_debug['var'])): ?>
                <?php foreach ($mvc4wp_debug['var'] as $var): ?>
                    <?php foreach ($var as $k => $v): ?>
                        <?php if (is_array($v) || is_object($v)): ?>
                            <div>
                                <input type='checkbox' id='debug-variable-named-<?php eh($k); ?>-toggle' class='checkbox'>
                                <label for='debug-variable-named-<?php eh($k); ?>-toggle' class='label debug-clickable'>
                                    <h4><i class="icon-plus"></i><?php eh($k); ?></h4>
                                </label>
                                <div class='expandable'>
                                    <pre class='debug-green'><?php eh(print_r($v, true)); ?></pre>
                                </div>
                            </div>
                        <?php else: ?>
                            <p>
                                <span class='name debug-cyan'><?php eh($k); ?></span>
                                <span class='value debug-green'> <?php eh(print_r($v, true)); ?></span>
                            </p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<?php if (!App::get()->config()->get('debug.variable.disable') || !in_array('global', App::get()->config()->get('debug.variable.disable'))): ?>
    <div class='expand-container'>
        <input type='checkbox' id='debug-variable-globals-toggle' class='checkbox'>
        <label for='debug-variable-globals-toggle' class='label debug-clickable'>
            <h4><i class="icon-plus"></i>Global variables</h4>
        </label>
        <div class='expand-containers expandable'>
            <?php foreach ($g as $k => $v): ?>
                <div class='expand-container'>
                    <input type='checkbox' id='debug-variable-<?php echo $k; ?>-toggle' class='checkbox'>
                    <label for='debug-variable-<?php echo $k; ?>-toggle' class='label debug-clickable'>
                        <h4><i class="icon-plus"></i>$_
                            <?php echo strtoupper($k); ?>
                        </h4>
                    </label>
                    <div class='expandable'>
                        <?php foreach ($v as $kk => $vv): ?>
                            <p>
                                <span class='name debug-cyan'>
                                    <?php eh($kk); ?>
                                </span>
                                <span class='value debug-green'>
                                    <?php if (is_array($vv) || is_object($vv)): ?>
                                        <pre class='debug-green'><?php eh(print_r($vv, true)); ?></pre>
                                    <?php else: ?>
                                        <?php eh(print_r($vv, true)); ?>
                                    <?php endif; ?>
                                </span>
                            </p>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<?php if (!App::get()->config()->get('debug.variable.disable') || !in_array('globals', App::get()->config()->get('debug.variable.disable'))): ?>
    <div class='expand-container'>
        <input type='checkbox' id='debug-variable-super-toggle' class='checkbox'>
        <label for='debug-variable-super-toggle' class='label debug-clickable'>
            <h4><i class="icon-plus"></i>$GLOBALS</h4>
        </label>
        <div class='expandable'>
            <?php foreach ($GLOBALS as $k => $v): ?>
                <?php if (!in_array($k, ['_GET', '_POST', '_COOKIE', '_FILES', '_ENV', '_REQUEST', '_SERVER'])): ?>
                    <p>
                        <span class='name debug-cyan'>
                            <?php eh($k); ?>
                        </span>
                        <span class='value debug-green'>
                            <?php if (is_array($v) || is_object($v)): ?>
                                <pre class='debug-green'><?php eh(print_r($v, true)); ?></pre>
                            <?php else: ?>
                                <?php eh(print_r($v, true)); ?>
                            <?php endif; ?>
                        </span>
                    </p>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>