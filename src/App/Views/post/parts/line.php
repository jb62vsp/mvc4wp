<?php declare(strict_types=1); ?>
<?php foreach ($data['columns'] as $column): ?>
    <td>
        <?php if ($column === 'ID'): ?>
            <a href="<?php echo '/post/' . eh($data['post']->ID); ?>">
                <?php echo eh($data['post']->ID); ?>
            </a>
        <?php else: ?>
            <?php echo nl2br(eh($data['post']->{$column})); ?>
        <?php endif; ?>
    </td>
<?php endforeach ?>