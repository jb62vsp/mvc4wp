<?php

declare(strict_types=1);

use Mvc4Wp\Core\Service\App;

?>
<?php global $mvc4wp_debug; ?>
<?php $has_error = array_key_exists('error', $mvc4wp_debug) && !empty($mvc4wp_debug['error']); ?>
<section id='debug' class='dark'>
    <div class='debug-container'>
        <span class="debug-toggle-area debug-show-toggle-area">
            <input type='checkbox' id='debug-show-toggle' class='debug-toggle-checkbox' checked>
            <label for='debug-show-toggle' class='debug-toggle-button debug_clickable'>
                <i title="Debug console toggle" class="debug-icon"></i>
            </label>
        </span>
        <span class="debug-toggle-area debug-view-toggle-area">
            <input type='checkbox' id='debug-view-toggle' class='debug-toggle-checkbox' checked>
            <label for='debug-view-toggle' class='debug-toggle-button'>
                <i title="Debug view toggle" class="debug-icon"></i>
            </label>
        </span>
        <div class='debug-contents'>
            <input id="debug-tab-radio-route" type="radio" name="debug-tab-radio" <?php eh(App::get()->config()->get('debug.route.off') === 'true' ? 'disabled' : ''); ?>>
            <label class="debug-tab-button <?php eh(App::get()->config()->get('debug.route.off') === 'true' ? 'debug-base2' : 'debug_clickable'); ?>" for="debug-tab-radio-route">Route</label>

            <input id="debug-tab-radio-view" type="radio" name="debug-tab-radio" <?php eh(App::get()->config()->get('debug.view.off') === 'true' ? 'disabled' : ''); ?>>
            <label class="debug-tab-button <?php eh(App::get()->config()->get('debug.view.off') === 'true' ? 'debug-base2' : 'debug_clickable'); ?>" for="debug-tab-radio-view">View</label>

            <input id="debug-tab-radio-variable" type="radio" name="debug-tab-radio" <?php eh(App::get()->config()->get('debug.variable.off') === 'true' ? 'disabled' : ''); ?>>
            <label class="debug-tab-button <?php eh(App::get()->config()->get('debug.variable.off') === 'true' ? 'debug-base2' : 'debug_clickable'); ?>" for="debug-tab-radio-variable">Variable</label>

            <input id="debug-tab-radio-query" type="radio" name="debug-tab-radio" <?php eh(App::get()->config()->get('debug.query.off') === 'true' ? 'disabled' : ''); ?>>
            <label class="debug-tab-button <?php eh(App::get()->config()->get('debug.query.off') === 'true' ? 'debug-base2' : 'debug_clickable'); ?>" for="debug-tab-radio-query">Query</label>

            <input id="debug-tab-radio-timer" type="radio" name="debug-tab-radio" <?php eh(App::get()->config()->get('debug.timer.off') === 'true' ? 'disabled' : ''); ?>>
            <label class="debug-tab-button <?php eh(App::get()->config()->get('debug.timer.off') === 'true' ? 'debug-base2' : 'debug_clickable'); ?>" for="debug-tab-radio-timer">Timer</label>

            <input id="debug-tab-radio-config" type="radio" name="debug-tab-radio" <?php eh(App::get()->config()->get('debug.config.off') === 'true' ? 'disabled' : ''); ?>>
            <label class="debug-tab-button <?php eh(App::get()->config()->get('debug.config.off') === 'true' ? 'debug-base2' : 'debug_clickable'); ?>" for="debug-tab-radio-config">Config</label>

            <input id="debug-tab-radio-sql" type="radio" name="debug-tab-radio" <?php eh(App::get()->config()->get('debug.sql.off') === 'true' ? 'disabled' : ''); ?>>
            <label class="debug-tab-button <?php eh(App::get()->config()->get('debug.sql.off') === 'true' ? 'debug-base2' : 'debug_clickable'); ?>" for="debug-tab-radio-sql">SQL</label>

            <input id="debug-tab-radio-error" type="radio" name="debug-tab-radio" <?php eh($has_error ? '' : 'disabled'); ?>>
            <label class="debug-tab-button <?php eh($has_error ? 'debug_red debug_clickable' : 'debug-base2'); ?>"
                for="debug-tab-radio-error">Error</label>

            <div class="debug-tab-container scrollbar" id="debug-tab-container-route">
                <?php if (App::get()->config()->get('debug.route.off') !== 'true') debug_view('route.php'); ?>
            </div>
            <div class="debug-tab-container scrollbar" id="debug-tab-container-view">
                <?php if (App::get()->config()->get('debug.view.off') !== 'true') debug_view('view.php'); ?>
            </div>
            <div class="debug-tab-container scrollbar" id="debug-tab-container-variable">
                <?php if (App::get()->config()->get('debug.variable.off') !== 'true') debug_view('variable.php'); ?>
            </div>
            <div class="debug-tab-container scrollbar" id="debug-tab-container-query">
                <?php if (App::get()->config()->get('debug.query.off') !== 'true') debug_view('query.php'); ?>
            </div>
            <div class="debug-tab-container scrollbar" id="debug-tab-container-timer">
                <?php if (App::get()->config()->get('debug.timer.off') !== 'true') debug_view('timer.php'); ?>
            </div>
            <div class="debug-tab-container scrollbar" id="debug-tab-container-config">
                <?php if (App::get()->config()->get('debug.config.off') !== 'true') debug_view('config.php'); ?>
            </div>
            <div class="debug-tab-container scrollbar" id="debug-tab-container-sql">
                <?php if (App::get()->config()->get('debug.sql.off') !== 'true') debug_view('sql.php'); ?>
            </div>
            <div class="debug-tab-container scrollbar" id="debug-tab-container-error">
                <?php debug_view('error.php'); ?>
            </div>
        </div>
    </div>
    <div class='padding'></div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('head').appendChild(document.querySelector('#debug_style'));
            document.querySelector('body').appendChild(document.querySelector('#debug'));
            document.querySelector('#debug #debug-show-toggle').addEventListener('change', ev => document.cookie = 'debug_show_toggle=' + (ev.target.checked ? 'true' : 'false') + '; Path=/');
            document.querySelector('#debug #debug-view-toggle').addEventListener('change', ev => document.cookie = 'debug_view_toggle=' + (ev.target.checked ? 'true' : 'false') + '; Path=/');
            document.querySelectorAll('#debug [name="debug-tab-radio"]').forEach(elm => elm.addEventListener('change', ev => document.cookie = 'debug_tab=' + ev.target.id + '; Path=/'));
            document.cookie.split(';').forEach(kv => {
                const context = kv.trim().split('=');
                if (context[0].trim() === 'debug_show_toggle') {
                    if (document.querySelector('#debug #debug-tab-radio-error').disabled) {
                        document.querySelector('#debug #debug-show-toggle').checked = context[1].trim() === 'true';
                    } else {
                        document.querySelector('#debug #debug-show-toggle').checked = true;
                        document.cookie = 'debug_show_toggle=true';
                    }
                }
                if (context[0].trim() === 'debug_view_toggle') {
                    document.querySelector('#debug #debug-view-toggle').checked = context[1].trim() === 'true';
                }
                if (context[0].trim() === 'debug_contents_height') {
                    document.querySelector('#debug .debug-contents').style = 'height: ' + context[1].trim() + 'px';
                }
                if (context[0].trim() === 'debug_tab') {
                    if (document.querySelector('#debug #debug-tab-radio-error').disabled) {
                        if (context[1].trim() === 'debug-tab-radio-error') {
                            document.querySelector('#debug #debug-tab-radio-route').checked = 'true';
                            document.cookie = 'debug_tab=debug-tab-radio-route';
                        } else {
                            document.querySelector('#debug #' + context[1].trim()).checked = 'true';
                        }
                    } else {
                        document.querySelector('#debug #debug-tab-radio-error').checked = 'true';
                        document.cookie = 'debug_tab=debug-tab-radio-error';
                    }
                }
            });
            new class {
                constructor(target) {
                    this.target = target;
                    this.height = this.target.clientHeight;
                    this.target.addEventListener('pointermove', this.resizeEvent);
                }

                resizeEvent = (ev) => {
                    const currentHeight = this.target.clientHeight;
                    if (this.height !== currentHeight) {
                        document.cookie = 'debug_contents_height=' + String(currentHeight) + '; Path=/';
                        this.height = currentHeight;
                    }
                }
            }(document.querySelector('#debug .debug-contents'));
        });
    </script>
</section>