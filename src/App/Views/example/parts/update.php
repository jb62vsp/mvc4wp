<?php declare(strict_types=1); ?>
<section>
    <h2>update</h2>
    <form action="<?php echo '/example/' . eh($data['id']); ?>" method='POST'>
        <p>
            <input type='text' name='post_title' value='<?php echo eh($data['examples'][0]->post_title); ?>'>
        </p>
        <p>
            <textarea name='post_content'><?php echo eh($data['examples'][0]->post_content); ?></textarea>
        </p>
        <p>
            <input type='text' name='example_string'
                value='<?php echo eh($data['examples'][0]->example_string); ?>'>
        </p>
        <p>
            <input type='text' name='example_int' value='<?php echo eh($data['examples'][0]->example_int); ?>'>
        </p>
        <p>
            <input type='text' name='example_float'
                value='<?php echo eh($data['examples'][0]->example_float); ?>'>
        </p>
        <p>
            <input type='text' name='example_bool' value='<?php echo eh($data['examples'][0]->example_bool); ?>'>
        </p>
        <p>
            <input type='text' name='example_datetime'
                value='<?php echo eh($data['examples'][0]->example_datetime); ?>'>
        </p>
        <p>
            <input type="hidden" name="_METHOD" value="PUT"><input type='submit' value='update'>
        </p>
    </form>
</section>