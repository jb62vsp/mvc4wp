<?php declare(strict_types=1); ?>
<?php foreach ($data['columns'] as $column): ?>
    <td>
        <?php if ($column === 'ID'): ?>
            <a href="<?php echo '/example/' . v($data['example']->ID); ?>">
                <?php echo v($data['example']->ID); ?>
            </a>
        <?php else: ?>
            <?php echo v($data['example']->{$column}); ?>
        <?php endif; ?>
    </td>
<?php endforeach ?>