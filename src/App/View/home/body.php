<?php declare(strict_types=1); ?>
<h1>
    <?php eh('Hello ' . $data['title']); ?>
</h1>
<?php if ($data['login'] === 'true'): ?>
<p>
    <a href='/logout'>logout</a>
</p>
<?php else: ?>
<p>
<a href='/login'>login</a>
</p>
<?php endif; ?>