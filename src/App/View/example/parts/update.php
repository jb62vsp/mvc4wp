<?php declare(strict_types=1); ?>
<section>
    <h2>update</h2>
    <form action="<?php eh($data['id']); ?>" method='POST'>
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
                            <?php eh($error->property_name . ': ' . $error->value . ', ' . $error->rule->getMessage()); ?>
                        </span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </p>
        <?php endforeach; ?>
        <p>
            <input type="hidden" name="_METHOD" value="PUT"><input type='submit' value='update'>
        </p>
    </form>
</section>