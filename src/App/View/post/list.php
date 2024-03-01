<?php declare(strict_types=1); ?>
<h1>
    <?php eh($data['title']); ?>: list
</h1>
<?php view('post/parts/table', $data); ?>
<?php view('post/parts/register', $data); ?>