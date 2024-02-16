<?php declare(strict_types=1); ?>
<section>
    <h2>register</h2>
    <?php foreach ($data['errors'] as $key => $error): ?>
        <p class="error">
            <?php echo $error->getMessage(); ?>
        </p>
    <?php endforeach; ?>
    <form action='/example/' method='POST'>
        <?php foreach ($data['editable_columns'] as $column): ?>
            <p>
                <label for='<?php echo $column; ?>'>
                    <?php echo $column; ?>
                </label>
                <?php if ($column === 'example_textarea'): ?>
                    <textarea id='<?php echo $column; ?>'
                        name='<?php echo $column; ?>'><?php echo array_key_exists($column, $data['post']) ? $data['post'][$column] : ''; ?></textarea>
                <?php else: ?>
                    <input type='text' id='<?php echo $column; ?>' name='<?php echo $column; ?>'
                        value='<?php echo array_key_exists($column, $data['post']) ? $data['post'][$column] : ''; ?>'>
                <?php endif; ?>
            </p>
        <?php endforeach; ?>
        <p>
            <input type='submit' value='register'>
        </p>
    </form>
</section>