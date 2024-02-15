<?php declare(strict_types=1);

use App\Controllers\exampleController;

?>
<section>
    <h2>table</h2>
    <table>
        <tr>
            <?php foreach ($data['columns'] as $column): ?>
                <th>
                    <?php if (array_key_exists('single', $data)): ?>
                        <?php echo $column; ?>
                    <?php else: ?>
                        <?php if ($column === $data['sort']): ?>
                            <a href="<?php echo "/example/list/{$column}/" . ($data['order'] === 'asc' ? 'desc' : 'asc'); ?>">
                                <?php echo $column; ?>
                                <?php echo ($data['order'] === 'asc' ? '▼' : '▲'); ?>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo "/example/list/{$column}"; ?>">
                                <?php echo $column; ?>▲
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </th>
            <?php endforeach ?>
        </tr>
        <?php foreach ($data['examples'] as $example): ?>
            <tr>
                <?php exampleController::cast($data['this'])->view('example/parts/line', ['example' => $example, 'columns' => $data['columns']]); ?>
            </tr>
        <?php endforeach; ?>
    </table>
</section>