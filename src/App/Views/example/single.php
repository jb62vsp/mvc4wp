<?php declare(strict_types=1);

use App\Controllers\exampleController;

?>
<h1>
    <?php echo $data['title']; ?>: single
</h1>
<section>
    <p><a href="/example/list">list</a></p>
</section>
<?php exampleController::cast($data['this'])->view('example/parts/table', $data); ?>
<?php exampleController::cast($data['this'])->view('example/parts/update', $data); ?>
<?php exampleController::cast($data['this'])->view('example/parts/delete', $data); ?>