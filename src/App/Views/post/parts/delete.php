<section>
    <h2>delete</h2>
    <form action="<?php echo "/post/{$data['id']}"; ?>" method='POST'>
        <p><input type="hidden" name="_METHOD" value="DELETE"><input type='submit' value='delete'></p>
    </form>
</section>