<?php declare(strict_types=1); ?>
<section>
    <h2>search</h2>
    <form action='/example/search' method='POST'>
        <p>
            <a href='/example/'>list</a>
        </p>
        <p>
            <label for='key'>key</label>
            <select name='key' id='key'>
                <?php foreach ($data['searchable_columns'] as $column): ?>
                    <option value='<?php echo $column; ?>' <?php echo array_key_exists('key', $_POST) && $_POST['key'] === $column ? 'selected' : '' ?>>
                        <?php echo $column; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for='value'>value</label>
            <input type='text' name='value' id='value'
                value='<?php echo array_key_exists('value', $_POST) ? eh($_POST['value']) : ''; ?>'>
        </p>
        <p>
            <label for='compare'>compare</label>
            <select name='compare' id='compare'>
                <?php $compares = ["=", "!=", ">", ">=", "<", "<=", "LIKE", "NOT LIKE", "IN", "NOT IN", "BETWEEN", "NOT BETWEEN", "EXISTS", "NOT EXISTS", "REGEXP", "NOT REGEXP", "RLIKE"]; ?>
                <?php foreach ($compares as $compare): ?>
                    <option value='<?php echo $compare; ?>' <?php echo array_key_exists('compare', $_POST) && $_POST['compare'] === $compare ? 'selected' : ''; ?>>
                        <?php echo eh($compare); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for='type'>type</label>
            <select name='type' id='type'>
                <?php $types = ["NUMERIC", "BINARY", "CHAR", "DATE", "DATETIME", "DECIMAL", "SIGNED", "TIME", "UNSIGNED"]; ?>
                <?php foreach ($types as $type): ?>
                    <option value='<?php echo $type; ?>' <?php echo array_key_exists('type', $_POST) && $_POST['type'] === $type ? 'selected' : ''; ?>>
                        <?php echo eh($type); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for='sort'>sort</label>
            <select name='sort' id='sort'>
                <?php foreach ($data['columns'] as $column): ?>
                    <option value='<?php echo $column; ?>' <?php echo array_key_exists('sort', $_POST) && $_POST['sort'] === $column ? 'selected' : ''; ?>>
                        <?php echo $column; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for='order'>order</label>
            <select name='order' id='order'>
                <?php $orders = ['asc', 'desc']; ?>
                <?php foreach ($orders as $order): ?>
                    <option value='<?php echo $order; ?>' <?php echo array_key_exists('order', $_POST) && $_POST['order'] === $order ? 'selected' : ''; ?>>
                        <?php echo $order; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <input type='submit' value='search'>
        </p>
    </form>
</section>