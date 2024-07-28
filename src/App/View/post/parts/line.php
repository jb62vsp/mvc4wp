<?php declare(strict_types=1); ?>
<?php foreach ($data['columns'] as $column): ?>
    <td>
        <?php if ($column === 'ID'): ?>
            <a href="<?php eh('/post/' . $data['post']->{$column}); ?>">
                <?php eh($data['post']->{$column}); ?>
            </a>
        <?php elseif ($column === 'post_name'): ?>
            <a href="<?php eh('/post/' . $data['post']->{$column} . '/'); ?>">
                <?php eh($data['post']->{$column}); ?>
            </a>
        <?php else: ?>
            <?php eh(strval($data['post']->{$column})); ?>
        <?php endif; ?>
    </td>
<?php endforeach ?>