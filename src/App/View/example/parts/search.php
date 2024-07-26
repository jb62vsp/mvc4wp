<?php declare(strict_types=1); ?>
<section>
    <h2>search</h2>
    <form action='/example/search' method='POST'>
        <p>
            <a href='/example/'>list</a>
        </p>
        <p>
            <label for='key'>key</label>
            <select name='key' id='key'>
                <?php foreach ($data['searchable_columns'] as $column): ?>
                    <option value='<?php eh($column); ?>' <?php eh(array_key_exists('key', $_POST) && $_POST['key'] === $column ? 'selected' : ''); ?>>
                        <?php eh($column); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for='value'>value</label>
            <input type='text' name='value' id='value'
                value='<?php eh(array_key_exists('value', $_POST) ? $_POST['value'] : ''); ?>'>
        </p>
        <p>
            <label for='compare'>compare</label>
            <select name='compare' id='compare'>
                <?php $compares = ["=", "!=", ">", ">=", "<", "<=", "LIKE", "NOT LIKE", "IN", "NOT IN", "BETWEEN", "NOT BETWEEN", "EXISTS", "NOT EXISTS", "REGEXP", "NOT REGEXP", "RLIKE"]; ?>
                <?php foreach ($compares as $compare): ?>
                    <option value='<?php eh($compare); ?>' <?php eh(array_key_exists('compare', $_POST) && $_POST['compare'] === $compare ? 'selected' : ''); ?>>
                        <?php eh($compare); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for='type'>type</label>
            <select name='type' id='type'>
                <?php $types = ["NUMERIC", "BINARY", "CHAR", "DATE", "DATETIME", "DECIMAL", "SIGNED", "TIME", "UNSIGNED"]; ?>
                <?php foreach ($types as $type): ?>
                    <option value='<?php eh($type); ?>' <?php eh(array_key_exists('type', $_POST) && $_POST['type'] === $type ? 'selected' : ''); ?>>
                        <?php eh($type); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for='sort'>sort</label>
            <select name='sort' id='sort'>
                <?php foreach ($data['columns'] as $column): ?>
                    <option value='<?php eh($column); ?>' <?php eh(array_key_exists('sort', $_POST) && $_POST['sort'] === $column ? 'selected' : ''); ?>>
                        <?php eh($column); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for='order'>order</label>
            <select name='order' id='order'>
                <?php $orders = ['asc', 'desc']; ?>
                <?php foreach ($orders as $order): ?>
                    <option value='<?php eh($order); ?>' <?php eh(array_key_exists('order', $_POST) && $_POST['order'] === $order ? 'selected' : ''); ?>>
                        <?php eh($order); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <dl>
            <dt>Categories</dt>
            <?php foreach ($data['categories'] as $category): ?>
                <dd>
                    <input type='checkbox' id='<?php eh("search_category_{$category->term_id}"); ?>'
                        name='categories[<?php echo eh("{$category->slug}"); ?>]' <?php eh(array_key_exists('categories', $_POST) && array_key_exists($category->slug, $_POST['categories']) ? 'checked' : ''); ?>>
                    <label for='<?php eh("search_category_{$category->term_id}"); ?>'>
                        <?php eh($category->name); ?>
                    </label>
                </dd>
            <?php endforeach; ?>
        </dl>
        <dl>
            <dt>Tags</dt>
            <?php foreach ($data['tags'] as $tag): ?>
                <dd>
                    <input type='checkbox' id='<?php eh("search_tag_{$tag->term_id}"); ?>'
                        name='tags[<?php echo eh($tag->slug); ?>]' <?php eh(array_key_exists('tags', $_POST) && array_key_exists($tag->slug, $_POST['tags']) ? 'checked' : ''); ?>>
                    <label for='<?php eh("search_tag_{$tag->term_id}"); ?>'>
                        <?php eh($tag->name); ?>
                    </label>
                </dd>
            <?php endforeach; ?>
        </dl>
        <p>
            <input type='submit' value='search'>
        </p>
    </form>
</section>