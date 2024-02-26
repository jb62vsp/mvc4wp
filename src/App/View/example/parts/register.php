<?php declare(strict_types=1); ?>
<section>
    <h2>register</h2>
    <?php if (array_key_exists('error', $data)): ?>
    <?php endif; ?>
    <form action='/example/' method='POST'>
        <?php foreach ($data['registerable_columns'] as $column): ?>
            <p>
                <label for='<?php eh($column); ?>'>
                    <?php eh($column); ?>
                </label>
                <?php if ($column === 'example_textarea'): ?>
                    <textarea id='<?php eh($column); ?>'
                        name='<?php eh($column); ?>'><?php eh(array_key_exists('post', $data) && array_key_exists($column, $data['post']) ? $data['post'][$column] : ''); ?></textarea>
                <?php else: ?>
                    <input type='text' id='<?php eh($column); ?>' name='<?php eh($column); ?>'
                        value='<?php eh(array_key_exists('post', $data) && array_key_exists($column, $data['post']) ? $data['post'][$column] : ''); ?>'>
                <?php endif; ?>
                <?php if (array_key_exists('errors', $data) && array_key_exists($column, $data['errors'])): ?>
                    <?php foreach ($data['errors'][$column] as $error): ?>
                        <span class="error">
                            <?php eh($error->rule->getMessage()); ?>
                        </span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </p>
        <?php endforeach; ?>
        <p>
            <input type='submit' value='register'>
        </p>
    </form>
</section>