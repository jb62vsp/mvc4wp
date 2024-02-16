<?php declare(strict_types=1); ?>
<section>
    <h2>update</h2>
    <?php foreach ($data['errors'] as $key => $error): ?>
        <p class="error">
            <?php echo $error->getMessage(); ?>
        </p>
    <?php endforeach; ?>
    <form action="<?php echo '/example/' . eh($data['id']); ?>" method='POST'>
        <?php foreach ($data['editable_columns'] as $column): ?>
            <p>
                <label for='<?php echo $column; ?>'>
                    <?php echo $column; ?>
                </label>
                <?php if ($column === 'example_textarea'): ?>
                    <textarea id='<?php echo $column; ?>'
                        name='<?php echo $column; ?>'><?php echo App\Models\ExampleModel::cast($data['examples'][0])->format($column); ?></textarea>
                <?php else: ?>
                    <input type='text' id='<?php echo $column; ?>' name='<?php echo $column; ?>'
                        value='<?php echo App\Models\ExampleModel::cast($data['examples'][0])->format($column); ?>'>
                <?php endif; ?>
            </p>
        <?php endforeach; ?>
        <p>
            <input type="hidden" name="_METHOD" value="PUT"><input type='submit' value='update'>
        </p>
    </form>
</section>