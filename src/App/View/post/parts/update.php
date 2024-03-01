<?php declare(strict_types=1); ?>
<section>
    <h2>update</h2>
    <form action="<?php eh('/post/' . $data['id']); ?>" method='POST'>
        <p>
            <input type='text' name='post_title' value='<?php eh($data['posts'][0]->post_title); ?>'>
        </p>
        <p>
            <textarea name='post_content'><?php eh($data['posts'][0]->post_content); ?></textarea>
        </p>
        <dl>
            <dt>Categories</dt>
            <?php foreach ($data['categories'] as $category): ?>
                <dd>
                    <input type='checkbox' id='<?php eh("category_{$category->term_id}"); ?>'
                        name='categories[<?php echo eh("{$category->slug}"); ?>]' <?php eh($data['posts'][0]->hasCategoryBySlug($category->slug) ? 'checked' : ''); ?>>
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
                        name='tags[<?php echo eh($tag->slug); ?>]' <?php eh($data['posts'][0]->hasTagBySlug($tag->slug) ? 'checked' : ''); ?>>
                    <label for='<?php eh("tag_{$tag->term_id}"); ?>'>
                        <?php eh($tag->name); ?>
                    </label>
                </dd>
            <?php endforeach; ?>
        </dl>
        <p>
            <input type="hidden" name="_METHOD" value="PUT">
            <input type='submit' value='update'>
        </p>
    </form>
</section>