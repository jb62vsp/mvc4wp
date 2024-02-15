<?php declare(strict_types=1);

use App\Controllers\exampleController;

?>
<h1>
    <?php echo $data['title']; ?>: list
</h1>
<?php exampleController::cast($data['this'])->view('example/parts/table', $data); ?>
<?php exampleController::cast($data['this'])->view('example/parts/register'); ?>