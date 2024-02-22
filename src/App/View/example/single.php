<?php declare(strict_types=1); ?>
<h1>
    <?php echo eh($data['title']); ?>: single
</h1>
<section>
    <p><a href="/example/list">list</a></p>
</section>
<?php view('example/parts/table', $data); ?>
<?php view('example/parts/update', $data); ?>
<?php view('example/parts/delete', $data); ?>