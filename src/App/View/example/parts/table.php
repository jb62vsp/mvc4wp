<?php declare(strict_types=1); ?>
<section>
    <h2>table</h2>
    <p>count:
        <?php eh($data['count']); ?>
    </p>
    <table>
        <tr>
            <?php foreach ($data['columns'] as $column): ?>
                <th>
                    <?php if (!array_key_exists('list', $data)): ?>
                        <?php eh($column); ?>
                    <?php else: ?>
                        <?php if ($column === $data['sort']): ?>
                            <a href="<?php eh("/example/list/{$column}/" . ($data['order'] === 'asc' ? 'desc' : 'asc')); ?>">
                                <?php eh($column); ?>
                                <?php eh(($data['order'] === 'asc' ? '▲' : '▼')); ?>
                            </a>
                        <?php elseif (in_array($column, $data['sortable_columns'])): ?>
                            <a href="<?php eh("/example/list/{$column}"); ?>">
                                <?php eh($column); ?>▲
                            </a>
                        <?php else: ?>
                            <?php eh($column); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </th>
            <?php endforeach ?>
        </tr>
        <?php foreach ($data['examples'] as $example): ?>
            <tr>
                <?php view('example/parts/line', ['example' => $example, 'columns' => $data['columns']]); ?>
            </tr>
        <?php endforeach; ?>
    </table>
</section>