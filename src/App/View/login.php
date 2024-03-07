<?php declare(strict_types=1); ?>
<?php view('header'); ?>
<form method='post' action='/login'>
    <label for='user_login'>ユーザ名</label>
    <input type="text" name="log" id="user_login" class="input" value="" size="20" autocapitalize="off"
        autocomplete="username" required="required">
    <label for='user_pass'>パスワード</label>
    <input type="password" name="pwd" id="user_pass" class="input password-input" value="" size="20"
        autocomplete="current-password" spellcheck="false" required="required">
    <button type='submit'>ログイン</button>
</form>
<?php view('footer'); ?>