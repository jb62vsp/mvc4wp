<?php declare(strict_types=1); ?>
<section>
    <h2>update</h2>
    <form action="<?php echo '/post/' . v($data['id']); ?>" method='POST'>
        <p>
            <input type='text' name='post_title' value='<?php echo v($data['posts'][0]->post_title); ?>'>
        </p>
        <p>
            <textarea name='post_content'><?php echo v($data['posts'][0]->post_content); ?></textarea>
        </p>
        <p>
            <input type="hidden" name="_METHOD" value="PUT">
            <input type='submit' value='update'>
        </p>
    </form>
</section>