<?php declare(strict_types=1); ?>
<section>
    <h2>delete</h2>
    <form action="<?php eh('/example/' . $data['id']); ?>" method='POST'>
        <p>
            <label for='untrash'>復元</label>
            <input type='radio' id='untrash' name='delete' value='untrash' checked>
            <label for='trush'>ゴミ箱</label>
            <input type='radio' id='trush' name='delete' value='trash'>
            <label for='delete'>削除</label>
            <input type='radio' id='delete' name='delete' value='delete'>
        </p>
        <p>
            <input type="hidden" name="_METHOD" value="DELETE">
            <input type="submit" value="delete">
        </p>
    </form>
</section>