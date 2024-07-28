<?php declare(strict_types=1);

use App\Model\CustomCatEntity;
use App\Model\CustomTagEntity;

?>
<section>
    <h2>update</h2>
    <form action="/example/<?php eh($data['id']); ?>" method='POST'>
        <?php foreach ($data['editable_columns'] as $column): ?>
            <p>
                <label for='<?php eh($column); ?>'>
                    <?php eh($column); ?>
                </label>
                <?php if ($column === 'example_textarea'): ?>
                    <textarea id='<?php eh($column); ?>'
                        name='<?php eh($column); ?>'><?php eh($data['examples'][0]->{$column}); ?></textarea>
                <?php else: ?>
                    <input type='text' id='<?php eh($column); ?>' name='<?php eh($column); ?>'
                        value='<?php eh($data['examples'][0]->{$column}); ?>'>
                <?php endif; ?>
                <?php if (array_key_exists('errors', $data) && array_key_exists($column, $data['errors'])): ?>
                    <?php foreach ($data['errors'][$column] as $error): ?>
                        <span class='error'>
                            <?php eh($error->rule->getMessage($data['messager'], ['field' => $column])); ?>
                        </span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </p>
        <?php endforeach; ?>
        <dl>
            <dt>Categories</dt>
            <?php foreach ($data['categories'] as $category): ?>
                <dd>
                    <input type='checkbox' id='<?php eh("category_{$category->term_id}"); ?>'
                        name='categories[<?php echo eh("{$category->slug}"); ?>]' <?php eh($data['examples'][0]->hasCategoryBySlug($category->slug, CustomCatEntity::class) ? 'checked' : ''); ?>>
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
                        name='tags[<?php echo eh($tag->slug); ?>]' <?php eh($data['examples'][0]->hasTagBySlug($tag->slug, CustomTagEntity::class) ? 'checked' : ''); ?>>
                    <label for='<?php eh("tag_{$tag->term_id}"); ?>'>
                        <?php eh($tag->name); ?>
                    </label>
                </dd>
            <?php endforeach; ?>
        </dl>
        <p>
            <input type="hidden" name="_METHOD" value="PUT"><input type='submit' value='update'>
        </p>
    </form>
</section>