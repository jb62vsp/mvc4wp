<?php declare(strict_types=1); ?>
<?php global $mvc4wp_debug; ?>
<section id='debug' class='dark'>
    <div class='debug-container'>
        <input type='checkbox' id='debug-toggle' class='debug-toggle-checkbox'>
        <label for='debug-toggle' class='debug-toggle-button clickable'>
            <i class="icon-arrow-top"></i>
        </label>
        <div class='debug-contents'>
            <input id="debug-tab-radio-route" type="radio" name="debug-tab-radio" <?php eh(array_key_exists('error', $mvc4wp_debug) && !empty($mvc4wp_debug['error']) ? '' : 'checked'); ?>>
            <label class="debug-tab-button clickable" for="debug-tab-radio-route">Route</label>

            <input id="debug-tab-radio-view" type="radio" name="debug-tab-radio">
            <label class="debug-tab-button clickable" for="debug-tab-radio-view">View</label>

            <input id="debug-tab-radio-variable" type="radio" name="debug-tab-radio">
            <label class="debug-tab-button clickable" for="debug-tab-radio-variable">Variable</label>

            <input id="debug-tab-radio-query" type="radio" name="debug-tab-radio">
            <label class="debug-tab-button clickable" for="debug-tab-radio-query">Query</label>

            <input id="debug-tab-radio-config" type="radio" name="debug-tab-radio">
            <label class="debug-tab-button clickable" for="debug-tab-radio-config">Config</label>

            <input id="debug-tab-radio-sql" type="radio" name="debug-tab-radio">
            <label class="debug-tab-button clickable" for="debug-tab-radio-sql">SQL</label>

            <input id="debug-tab-radio-error" type="radio" name="debug-tab-radio" <?php eh(array_key_exists('error', $mvc4wp_debug) && !empty($mvc4wp_debug['error']) ? 'checked' : ''); ?>>
            <label class="debug-tab-button clickable <?php eh(array_key_exists('error', $mvc4wp_debug) && !empty($mvc4wp_debug['error']) ? 'red' : 'base2'); ?>" for="debug-tab-radio-error">Error</label>

            <div class="debug-tab-container scrollbar" id="debug-tab-container-route">
                <?php debug_view('route.php'); ?>
            </div>
            <div class="debug-tab-container scrollbar" id="debug-tab-container-view">
                <?php debug_view('view.php'); ?>
            </div>
            <div class="debug-tab-container scrollbar" id="debug-tab-container-variable">
                <?php debug_view('variable.php'); ?>
            </div>
            <div class="debug-tab-container scrollbar" id="debug-tab-container-query">
                <?php debug_view('query.php'); ?>
            </div>
            <div class="debug-tab-container scrollbar" id="debug-tab-container-config">
                <?php debug_view('config.php'); ?>
            </div>
            <div class="debug-tab-container scrollbar" id="debug-tab-container-sql">
                <?php debug_view('sql.php'); ?>
            </div>
            <div class="debug-tab-container scrollbar" id="debug-tab-container-error">
                <?php debug_view('error.php'); ?>
            </div>
        </div>
    </div>
    <div class='padding'></div>
    <script>
        document.querySelector('head').appendChild(document.querySelector('#debug_style'));
        document.querySelector('body').appendChild(document.querySelector('#debug'));
    </script>
</section>