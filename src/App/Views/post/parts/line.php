<?php declare(strict_types=1); ?>
<?php foreach ($data['columns'] as $column): ?>
    <td>
        <?php if ($column === 'ID'): ?>
            <a href="<?php echo '/post/' . v($data['post']->ID); ?>">
                <?php echo v($data['post']->ID); ?>
            </a>
        <?php else: ?>
            <?php echo v($data['post']->{$column}); ?>
        <?php endif; ?>
    </td>
<?php endforeach ?>