<?php declare(strict_types=1);

global $mvc4wp_debug;

?>
<section id='debug'>
    <div class='debug-container'>
        <input type='checkbox' id='debug-toggle' checked>
        <label for='debug-toggle' class='toggle-button'>
            <span class='bar base3'></span>
            <span class='bar base3'></span>
            <span class='bar base3'></span>
        </label>
        <div class='debug-contents tabs base0'>
            <input id='view' type='radio' name='tab' checked>
            <label class='tab base00 base0' for='view'>View</label>

            <input id='vars' type='radio' name='tab'>
            <label class='tab base00 base0' for='vars'>Vars</label>

            <input id='query' type='radio' name='tab'>
            <label class='tab base00 base0' for='query'>Query</label>

            <input id='route' type='radio' name='tab'>
            <label class='tab base00 base0' for='route'>Route</label>

            <div class='tab_content base03 base3' id='view_content'>
            </div>

            <div class='tab_content base03' id='vars_content'>
                <h3 class='cyan'>$_COOKIE</h3>
                <?php foreach ($_COOKIE as $k => $v): ?>
                    <p>
                        <?php printf("%s => %s", $k, eh($v, true)); ?>
                    </p>
                <?php endforeach; ?>
                <h3 class='cyan'>$_GET</h3>
                <?php foreach ($_GET as $k => $v): ?>
                    <p>
                        <?php printf("%s => %s", $k, eh($v, true)); ?>
                    </p>
                <?php endforeach; ?>
                <h3 class='cyan'>$_POST</h3>
                <?php foreach ($_POST as $k => $v): ?>
                    <p>
                        <?php printf("%s => %s", $k, eh($v, true)); ?>
                    </p>
                <?php endforeach; ?>
                <h3 class='cyan'>$_REQUEST</h3>
                <?php foreach ($_REQUEST as $k => $v): ?>
                    <p>
                        <?php printf("%s => %s", $k, eh($v, true)); ?>
                    </p>
                <?php endforeach; ?>
                <h3 class='cyan'>$_SERVER</h3>
                <?php foreach ($_SERVER as $k => $v): ?>
                    <p>
                        <?php printf("%s => %s", $k, eh($v, true)); ?>
                    </p>
                <?php endforeach; ?>
            </div>

            <div class='tab_content base03' id='query_content'>
                <?php foreach ($mvc4wp_debug['sql'] as $sql): ?>
                    <p data-mictorime='<?php eh($sql['microtime']); ?>'>
                        <?php eh($sql['sql']); ?>
                    </p>
                <?php endforeach; ?>
            </div>

            <div class='tab_content base03' id='route_content'>
                TODO:
            </div>
        </div>
    </div>
    <script>
        document.querySelector('head').appendChild(document.querySelector('#debug_style'));
        document.querySelector('body').appendChild(document.querySelector('#debug'));
        document.querySelector('#debug-toggle').addEventListener('change', ev => {
            if (ev.target.checked) {
                document.querySelectorAll('.debug.view').forEach(e => e.classList.remove('hide'));
            } else {
                document.querySelectorAll('.debug.view').forEach(e => e.classList.add('hide'));
            }
        });
    </script>
</section>