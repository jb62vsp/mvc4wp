<?php declare(strict_types=1);

use App\Controllers\PostController;

?>
<h1>
    <?php echo $data['title']; ?>: list
</h1>
<?php PostController::cast($data['this'])->view('post/parts/table', $data); ?>
<?php PostController::cast($data['this'])->view('post/parts/register'); ?>