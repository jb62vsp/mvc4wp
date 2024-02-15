<?php declare(strict_types=1); ?>
<h1>
    <?php echo v($data['title']); ?>: list
</h1>
<?php view('example/parts/table', $data); ?>
<?php view('example/parts/register'); ?>