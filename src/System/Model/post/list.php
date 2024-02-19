<?php declare(strict_types=1); ?>
<h1>
    <?php echo eh($data['title']); ?>: list
</h1>
<?php view('post/parts/table', $data); ?>
<?php view('post/parts/register'); ?>