<?php declare(strict_types=1); ?>
<h1>
    <?php echo $data['title']; ?>: single
</h1>
<section>
    <p><a href="/post/list">list</a></p>
</section>
<?php view('post/parts/table', $data); ?>
<?php view('post/parts/update', $data); ?>
<?php view('post/parts/delete', $data); ?>