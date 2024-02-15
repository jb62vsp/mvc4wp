<?php declare(strict_types=1);

use App\Controllers\PostController;

?>
<h1>
    <?php echo $data['title']; ?>: single
</h1>
<section>
    <p><a href="/post/list">list</a></p>
</section>
<?php PostController::cast($data['this'])->view('post/parts/table', $data); ?>
<?php PostController::cast($data['this'])->view('post/parts/update', $data); ?>
<?php PostController::cast($data['this'])->view('post/parts/delete', $data); ?>