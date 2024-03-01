<?php declare(strict_types=1); ?>
<section>
    <h2>register</h2>
    <form action='/post/' method='POST'>
        <p><input type='text' name='post_title'></p>
        <p><textarea name='post_content'></textarea></p>
        <dl>
            <dt>Categories</dt>
            <?php foreach ($data['categories'] as $category): ?>
                <dd>
                    <input type='checkbox' id='<?php eh("category_{$category->term_id}"); ?>'
                        name='categories[<?php echo eh("{$category->slug}"); ?>]'>
                    <label for='<?php eh("category_{$category->term_id}"); ?>'>
                        <?php eh($category->name); ?>
                    </label>
                </dd>
            <?php endforeach; ?>
        </dl>
        <dl>
            <dt>Tags</dt>
            <?php foreach ($data['tags'] as $tag): ?>
                <dd>
                    <input type='checkbox' id='<?php eh("tag_{$tag->term_id}"); ?>'
                        name='tags[<?php echo eh($tag->slug); ?>]'>
                    <label for='<?php eh("tag_{$tag->term_id}"); ?>'>
                        <?php eh($tag->name); ?>
                    </label>
                </dd>
            <?php endforeach; ?>
        </dl>
        <p><input type='submit' value='register'></p>
    </form>
</section>