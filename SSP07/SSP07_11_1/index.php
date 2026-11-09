<?php

// ssp07 ex 11-1 - array operations
// apollo is php 5.5 so no strict_types, no ?? and no arrow functions

$fruits = ['apple', 'banana', 'cherry', 'date', 'elderberry'];

// what the user did: 'search' or 'sort'
$action = filter_input(INPUT_POST, 'action');
$search = filter_input(INPUT_POST, 'search');
if ($search === null || $search === false) {
    $search = '';
}
$search = trim($search);

$message = '';
$error = '';
$sorted = [];

if ($action === 'search') {
    if ($search === '') {
        $error = 'Please type a fruit to search for.';
    } elseif (!preg_match('/^[A-Za-z]+$/', $search)) {
        // letters only, so don't search
        $error = 'Letters only please, no numbers or symbols.';
    } else {
        // third argument true makes in_array strict
        $found = in_array(strtolower($search), $fruits, true);
        $message = $found ? 'Found: ' . $search : 'Not found: ' . $search;
    }
} elseif ($action === 'sort') {
    // copy first so the original list stays the same
    $sorted = $fruits;
    sort($sorted);
}

// arrow functions need php 7.4 so this is a normal closure
$upper = array_map(function ($f) {
    return strtoupper($f);
}, $fruits);

// keep fruits with 6 or more letters, array_values fixes the index gaps
$long_fruits = array_values(array_filter($fruits, function ($f) {
    return strlen($f) >= 6;
}));

// array of arrays, acts like rows from a database
$catalog = [
    ['id' => 1, 'name' => 'Apple', 'price' => 1.29],
    ['id' => 2, 'name' => 'Banana', 'price' => 0.49],
    ['id' => 3, 'name' => 'Cherry', 'price' => 2.99],
    ['id' => 4, 'name' => 'Dragonfruit', 'price' => 4.99],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS2623 SSP07 Ex 11-1: Johnston</title>
    <link rel="stylesheet" href="../../SSP01/main.css">
</head>
<body>
    <main>
        <h1>Fruit Array Demo</h1>

        <form method="post">
            <label>Search fruit:
                <input type="text" name="search"
                    value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>">
            </label>
            <button type="submit" name="action" value="search">Search</button>
            <button type="submit" name="action" value="sort">Sort A-Z</button>
        </form>

        <?php if ($error !== ''): ?>
            <p><strong><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></strong></p>
        <?php endif; ?>

        <?php if ($message !== ''): ?>
            <p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <h2>Original List (<?php echo (int) count($fruits); ?> items)</h2>
        <ul>
            <?php foreach ($fruits as $f): ?>
                <li><?php echo htmlspecialchars($f, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>

        <?php if ($action === 'sort'): ?>
            <h2>Sorted A-Z</h2>
            <ul>
                <?php foreach ($sorted as $s): ?>
                    <li><?php echo htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <h2>Uppercase (array_map)</h2>
        <ul>
            <?php foreach ($upper as $u): ?>
                <li><?php echo htmlspecialchars($u, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>

        <h2>6 or More Letters (array_filter)</h2>
        <ul>
            <?php foreach ($long_fruits as $lf): ?>
                <li><?php echo htmlspecialchars($lf, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>

        <h2>Catalog (array of arrays)</h2>
        <table border="1" cellpadding="6" cellspacing="0">
            <tr><th>ID</th><th>Name</th><th>Price</th></tr>
            <?php foreach ($catalog as $row): ?>
                <tr>
                    <td><?php echo (int) $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>$<?php echo htmlspecialchars(number_format((float) $row['price'], 2), ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
</body>
</html>
