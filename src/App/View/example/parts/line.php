<?php declare(strict_types=1); ?>
<?php foreach ($data['columns'] as $column): ?>
    <td>
        <?php if ($column === 'ID'): ?>
            <a href="<?php eh('/example/' . $data['example']->ID); ?>">
                <?php eh($data['example']->ID); ?>
            </a>
        <?php else: ?>
            <?php eh(nl2br(strval($data['example']->{$column}))); ?>
        <?php endif; ?>
    </td>
<?php endforeach ?>