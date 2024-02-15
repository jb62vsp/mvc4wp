<?php declare(strict_types=1); ?>
<?php foreach ($data['columns'] as $column): ?>
    <td>
        <?php if ($column === 'ID'): ?>
            <a href="<?php echo "/example/" . $data['example']->ID; ?>">
                <?php echo $data['example']->ID; ?>
            </a>
        <?php else: ?>
            <?php echo $data['example']->{$column}; ?>
        <?php endif; ?>
    </td>
<?php endforeach ?>