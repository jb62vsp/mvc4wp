<?php declare(strict_types=1); ?>
<?php foreach ($data['columns'] as $column): ?>
    <td>
        <?php if ($column === 'ID'): ?>
            <a href="<?php echo "/post/" . $data['post']->ID; ?>">
                <?php echo $data['post']->ID; ?>
            </a>
        <?php else: ?>
            <?php echo $data['post']->{$column}; ?>
        <?php endif; ?>
    </td>
<?php endforeach ?>