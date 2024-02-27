<?php declare(strict_types=1); ?>
<style id='debug_head'>
    #debug .base03 {
        background-color: #002b36;
    }

    #debug .base02 {
        background-color: #073642;
    }

    #debug .base01 {
        background-color: #586e75;
    }

    #debug .base00 {
        background-color: #657b83;
    }

    #debug .base0 {
        color: #839496;
    }

    #debug .base1 {
        color: #93a1a1;
    }

    #debug .base2 {
        color: #eee8d5;
    }

    #debug .base3 {
        color: #fdf6e3;
    }

    #debug .yellow {
        color: #b58900;
    }

    #debug .orange {
        color: #cb4b16;
    }

    #debug .red {
        color: #dc322f;
    }

    #debug .magenta {
        color: #d33682;
    }

    #debug .violet {
        color: #6c71c4;
    }

    #debug .blue {
        color: #268bd2;
    }

    #debug .cyan {
        color: #2aa198;
    }

    #debug .green {
        color: #859900;
    }

    .debug.view {
        font-size: 12px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
        padding: 2px;
        margin-bottom: 2px;
        border-bottom: 2px solid #268bd2;
        background-color: #073642;
        color: #93a1a1;
    }

    .debug.view.hide {
        display: none;
    }

    #debug {
        font-size: 12px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
    }

    #debug .debug-container {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        overflow: hidden;
    }

    #debug .toggle-button {
        display: block;
        position: fixed;
        bottom: 2px;
        right: 2px;
        cursor: pointer;
        z-index: 2;
    }

    #debug .toggle-button .bar {
        display: block;
        width: 25px;
        height: 3px;
        margin: 5px 0;
        transition: 0.3s;
        background-color: #002b36
    }

    #debug .toggle-button:hover .bar:nth-child(1) {
        transform: translate(0px, -6px);
    }

    #debug .toggle-button:hover .bar:nth-child(2) {
        transform: translate(0px, -3px);
    }

    #debug .toggle-button:hover .bar:nth-child(3) {
        transform: translate(0px, 0px);
    }

    #debug .toggle-button .bar:nth-child(1) {
        opacity: 1;
    }

    #debug .toggle-button .bar:nth-child(2) {
        opacity: 0.8;
    }

    #debug .toggle-button .bar:nth-child(3) {
        opacity: 0.6;
    }

    #debug #debug-toggle:checked~.toggle-button .bar {
        background-color: #fdf6e3;
    }

    #debug #debug-toggle:checked~.toggle-button .bar:nth-child(1) {
        opacity: 0.6;
    }

    #debug #debug-toggle:checked~.toggle-button .bar:nth-child(2) {
        opacity: 0.8;
    }

    #debug #debug-toggle:checked~.toggle-button .bar:nth-child(3) {
        opacity: 1;
    }

    #debug #debug-toggle:checked~.debug-contents {
        bottom: 0;
    }

    #debug #debug-toggle {
        display: none;
    }

    #debug .debug-contents {
        position: fixed;
        bottom: -100%;
        left: 0;
        width: 100%;
        height: 50%;
        transition: 0.3s;
        z-index: 1;
    }

    #debug .tabs {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        margin: 0 auto;
        padding: 0 0 30px 0;
    }

    #debug .tab {
        width: calc(100%/4);
        height: 30px;
        line-height: 30px;
        font-size: 16px;
        text-align: center;
        display: block;
        float: left;
        text-align: center;
        font-weight: bold;
        transition: 0.3s;
    }

    #debug .tab:hover {
        opacity: 0.9;
    }

    #debug input[name='tab'] {
        display: none;
    }

    #debug .tab_content {
        display: none;
        clear: both;
        overflow: auto;
        height: 100%;
    }

    #debug .tab_content H3 {
        cursor: pointer;
    }

    #debug .tab_content P {
        padding-left: 2rem;
    }

    #debug .tab_content P:hover {
        background-color: #073642;
    }

    #debug #view:checked~#view_content,
    #debug #vars:checked~#vars_content,
    #debug #query:checked~#query_content,
    #debug #route:checked~#route_content {
        display: block;
    }

    #debug .tabs input:checked+.tab {
        background-color: #002b36;
        color: #839496;
    }
</style>