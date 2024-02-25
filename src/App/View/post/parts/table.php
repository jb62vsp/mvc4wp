<?php declare(strict_types=1); ?>
<section>
    <h2>table</h2>
    <p>count:
        <?php echo eh(count($data['posts'])); ?>
    </p>
    <table>
        <tr>
            <?php foreach ($data['columns'] as $column): ?>
                <th>
                    <?php if (array_key_exists('single', $data)): ?>
                        <?php echo eh($column); ?>
                    <?php else: ?>
                        <?php if ($column === $data['sort']): ?>
                            <a
                                href="<?php echo eh("/post/list/{$column}/" . ($data['order'] === 'asc' ? 'desc' : 'asc')); ?>">
                                <?php echo eh($column); ?>
                                <?php echo eh(($data['order'] === 'asc' ? '▲' : '▼')); ?>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo eh("/post/list/{$column}"); ?>">
                                <?php echo eh($column); ?>▲
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </th>
            <?php endforeach ?>
        </tr>
        <?php foreach ($data['posts'] as $post): ?>
            <tr>
                <?php view('post/parts/line', ['post' => $post, 'columns' => $data['columns']]); ?>
            </tr>
        <?php endforeach; ?>
    </table>
</section>