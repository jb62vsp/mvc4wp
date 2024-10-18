<?php declare(strict_types=1); ?>
<?php view('header', ['title' => 'Login']); ?>
<form method='post' action='/login'>
    <label for='user_login'>ユーザ名</label>
    <input type="text" name="id" id="id" class="input" value="" size="20" autocapitalize="off" autocomplete="username"
        required="required">
    <label for='user_pass'>パスワード</label>
    <input type="password" name="password" id="password" class="input password-input" value="" size="20"
        autocomplete="current-password" spellcheck="false" required="required">
    <button type='submit'>ログイン</button>
    <?php if (key_exists('error', $data)): ?>
        <p><?php eh($data['error']); ?></p>
    <?php endif; ?>
</form>
<?php view('footer'); ?>