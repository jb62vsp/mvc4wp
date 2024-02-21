<?php declare(strict_types=1); ?>
<?php foreach ($data['columns'] as $column): ?>
    <td>
        <?php if ($column === 'ID'): ?>
            <a href="<?php echo '/example/' . eh($data['example']->ID); ?>">
                <?php echo eh($data['example']->ID); ?>
            </a>
        <?php else: ?>
            <?php echo nl2br(strval($data['example']->{$column})); ?>
        <?php endif; ?>
    </td>
<?php endforeach ?>