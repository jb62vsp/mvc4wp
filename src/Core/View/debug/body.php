<?php declare(strict_types=1); ?>
<?php global $mvc4wp_debug; ?>
<?php $has_error = array_key_exists('error', $mvc4wp_debug) && !empty($mvc4wp_debug['error']); ?>
<section id='debug' class='dark'>
    <div class='debug-container'>
        <input type='checkbox' id='debug-toggle' class='debug-toggle-checkbox'>
        <label for='debug-toggle' class='debug-toggle-button clickable'>
            <i class="icon-arrow-top"></i>
        </label>
        <div class='debug-contents'>
            <input id="debug-tab-radio-route" type="radio" name="debug-tab-radio">
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

            <input id="debug-tab-radio-error" type="radio" name="debug-tab-radio" <?php eh($has_error ? '' : 'disabled'); ?>>
            <label class="debug-tab-button <?php eh($has_error ? 'red clickable' : 'base2'); ?>"
                for="debug-tab-radio-error">Error</label>

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
        document.querySelector('#debug #debug-toggle').addEventListener('change', ev => document.cookie = 'debug-toggle=' + (ev.target.checked ? 'true' : 'false'));
        document.querySelectorAll('#debug [name="debug-tab-radio"]').forEach(elm => elm.addEventListener('change', ev => document.cookie = 'debug-tab=' + ev.target.id));
        document.cookie.split(';').forEach(kv => {
            const context = kv.trim().split('=');
            if (context[0].trim() === 'debug-toggle') {
                if (document.querySelector('#debug #debug-tab-radio-error').disabled) {
                    document.querySelector('#debug #debug-toggle').checked = context[1].trim() === 'true';
                } else {
                    document.querySelector('#debug #debug-toggle').checked = true;
                    document.cookie = 'debug-toggle=true';
                }
            }
            if (context[0].trim() === 'debug-tab') {
                if (document.querySelector('#debug #debug-tab-radio-error').disabled) {
                    if (context[1].trim() === 'debug-tab-radio-error') {
                        document.querySelector('#debug #debug-tab-radio-route').checked = 'true';
                        document.cookie = 'debug-tab=debug-tab-radio-route';
                    } else {
                        document.querySelector('#debug #' + context[1].trim()).checked = 'true';
                    }
                } else {
                    document.querySelector('#debug #debug-tab-radio-error').checked = 'true';
                    document.cookie = 'debug-tab=debug-tab-radio-error';
                }
            }
        });
    </script>
</section>