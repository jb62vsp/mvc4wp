<?php declare(strict_types=1); ?>
<section>
    <h2>update</h2>
    <form action="<?php echo '/example/' . eh($data['id']); ?>" method='POST'>
        <?php foreach ($data['editable_columns'] as $column): ?>
            <p>
                <label for='<?php echo $column; ?>'>
                    <?php echo $column; ?>
                </label>
                <?php if ($column === 'example_textarea'): ?>
                    <textarea id='<?php echo $column; ?>'
                        name='<?php echo $column; ?>'><?php echo App\Model\ExampleModel::cast($data['examples'][0])->format($column); ?></textarea>
                <?php else: ?>
                    <input type='text' id='<?php echo $column; ?>' name='<?php echo $column; ?>'
                        value='<?php echo App\Model\ExampleModel::cast($data['examples'][0])->format($column); ?>'>
                <?php endif; ?>
                <?php if (array_key_exists($column, $data['errors'])): ?>
                    <?php foreach ($data['errors'][$column] as $error): ?>
                        <span class='error'>
                            <?php echo $error->property_name . ': ' . $error->value . ', ' . $error->rule->getMessage(); ?>
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