<?php declare(strict_types=1);

global $mvc4wp_debug;

?>
<section id='debug' class='dark'>
    <div class='debug-container'>
        <input type='checkbox' id='debug-toggle'>
        <label for='debug-toggle' class='debug-toggle-button'>
            <span class='bar'></span>
            <span class='bar'></span>
            <span class='bar'></span>
        </label>
        <div class='debug-contents'>
            <input id="debug-tab-radio01" type="radio" name="debug-tab-radio" checked>
            <label class="debug-tab-button" for="debug-tab-radio01">View</label>

            <input id="debug-tab-radio02" type="radio" name="debug-tab-radio">
            <label class="debug-tab-button" for="debug-tab-radio02">Query</label>

            <div class="debug-tab-container scrollbar" id="debug-tab-container01">
                <p>view</p>
                <p>view</p>
                <p>view</p>
                <p>view</p>
                <p>view</p>
                <p>view</p>
                <p>view</p>
                <p>view</p>
                <p>view</p>
                <p>view</p>
                <p>view</p>
                <p>view</p>
                <p>view</p>
                <p>view</p>
            </div>
            <div class="debug-tab-container scrollbar" id="debug-tab-container02">
                <p>query</p>
                <p>query</p>
                <p>query</p>
                <p>query</p>
                <p>query</p>
                <p>query</p>
                <p>query</p>
                <p>query</p>
                <p>query</p>
                <p>query</p>
                <p>query</p>
                <p>query</p>
                <p>query</p>
                <p>query</p>
                <p>query</p>
            </div>
        </div>
    </div>
    <div class='padding'></div>
    <script>
        document.querySelector('head').appendChild(document.querySelector('#debug_style'));
        document.querySelector('body').appendChild(document.querySelector('#debug'));
    </script>
</section>