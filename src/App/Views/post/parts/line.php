<?php declare(strict_types=1);

use System\Models\PostModel;

$post = $data['post'];
?>
<?php foreach (PostModel::getBindableFieldNames() as $name): ?>
    <td>
        <?php if ($name === 'ID'): ?>
            <a href="<?php echo "/post/{$post->ID}"; ?>">
                <?php echo $post->ID; ?>
            </a>
        <?php else: ?>
            <?php echo $post->{$name}; ?>
        <?php endif; ?>
    </td>
<?php endforeach ?>