<?php declare(strict_types=1);

use App\Controllers\PostController;
use System\Models\PostModel;

?>
<section>
    <h2>table</h2>
    <table>
        <tr>
            <?php foreach (PostModel::getBindableFieldNames() as $name): ?>
                <th>
                    <?php if (array_key_exists('single', $data)): ?>
                        <?php echo $name; ?>
                    <?php else: ?>
                        <?php if ($name === $data['sort']): ?>
                            <a href="<?php echo "/post/list/{$name}/" . ($data['order'] === 'asc' ? 'desc' : 'asc'); ?>">
                                <?php echo $name; ?>
                                <?php echo ($data['order'] === 'asc' ? '▼' : '▲'); ?>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo "/post/list/{$name}"; ?>">
                                <?php echo $name; ?>▲
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </th>
            <?php endforeach ?>
        </tr>
        <?php foreach ($data['posts'] as $post): ?>
            <tr>
                <?php PostController::cast($data['this'])->view('post/parts/line', ['post' => $post]); ?>
            </tr>
        <?php endforeach; ?>
    </table>
</section>