<?php declare(strict_types=1); ?>
<section>
    <h2>delete</h2>
    <form action="<?php eh('/post/' . $data['id']); ?>" method='POST'>
        <p>
            <label for='trush'>復元</label>
            <input type='radio' id='untrush' name='to_trush' value='untrash' checked>
            <label for='trush'>ゴミ箱</label>
            <input type='radio' id='trush' name='to_trush' value='trash'>
            <label for='delete'>削除</label>
            <input type='radio' id='delete' name='to_trush' value='delete'>
        </p>
        <p>
            <input type="hidden" name="_METHOD" value="DELETE">
            <input type="submit" value="delete">
        </p>
    </form>
</section>