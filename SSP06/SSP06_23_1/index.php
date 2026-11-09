<?php

// ssp06 ex 23-1 - product catalog and cart

// login required, the path is built from this file's folder
require __DIR__ . '/../SSP06_21_2/auth.php';

$products = [
    1 => ['id' => 1, 'name' => 'Fender Stratocaster', 'price' => 499.99],
    2 => ['id' => 2, 'name' => 'Gibson Les Paul', 'price' => 799.99],
    3 => ['id' => 3, 'name' => 'Martin D-28 Acoustic', 'price' => 1299.99],
    4 => ['id' => 4, 'name' => 'Ibanez RG550', 'price' => 299.99],
];

// make the cart once, ??= needs php 7.4 so this is the old way
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// check if a button was pressed
$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
if ($method === null) {
    // backup in case the server doesn't fill INPUT_SERVER
    $method = $_SERVER['REQUEST_METHOD'];
}

if ($method === 'POST') {
    $action = filter_input(INPUT_POST, 'action');
    $id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

    // only use the id if it's a real whole number and a real product
    if ($id !== null && $id !== false && isset($products[$id])) {
        // start at 0 if it isn't in the cart yet
        $current = isset($_SESSION['cart'][$id]) ? $_SESSION['cart'][$id] : 0;

        if ($action === 'add') {
            $_SESSION['cart'][$id] = $current + 1;
        } elseif ($action === 'remove' && $current > 0) {
            if ($current - 1 <= 0) {
                // nothing left so take it out of the cart
                unset($_SESSION['cart'][$id]);
            } else {
                $_SESSION['cart'][$id] = $current - 1;
            }
        }
    }

    // redirect so refreshing doesn't resubmit the form
    header('Location: index.php');
    exit;
}

// cart total and item count
$total = 0.0;
$item_count = 0;
foreach ($_SESSION['cart'] as $pid => $qty) {
    if (isset($products[$pid])) {
        $total += $products[$pid]['price'] * $qty;
        $item_count += $qty;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS2623 SSP06 Cart: Johnston</title>
    <link rel="stylesheet" href="../../SSP01/main.css">
</head>
<body>
    <header>
        <h1>Guitar Shop</h1>
        <p>Cart (<?php echo (int) $item_count; ?> <?php echo $item_count === 1 ? 'item' : 'items'; ?>)
            | <a href="../SSP06_21_2/dashboard.php">Dashboard</a>
            | <a href="../SSP06_21_2/logout.php">Log out</a></p>
    </header>
    <main>
        <h2>Products</h2>
        <?php foreach ($products as $p): ?>
            <div class="product">
                <h3><?php echo htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <p>$<?php echo htmlspecialchars(number_format($p['price'], 2), ENT_QUOTES, 'UTF-8'); ?></p>
                <form method="post">
                    <input type="hidden" name="product_id" value="<?php echo (int) $p['id']; ?>">
                    <button type="submit" name="action" value="add">Add to Cart</button>
                </form>
            </div>
        <?php endforeach; ?>

        <h2>Your Cart</h2>
        <?php if (empty($_SESSION['cart'])): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table border="1" cellpadding="6" cellspacing="0">
                <tr><th>Product</th><th>Qty</th><th>Subtotal</th><th></th></tr>
                <?php foreach ($_SESSION['cart'] as $pid => $qty): ?>
                    <?php if (isset($products[$pid])): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($products[$pid]['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo (int) $qty; ?></td>
                            <td>$<?php echo htmlspecialchars(number_format($products[$pid]['price'] * $qty, 2), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="product_id" value="<?php echo (int) $pid; ?>">
                                    <button type="submit" name="action" value="remove">Remove one</button>
                                </form>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2"><strong>Total</strong></td>
                    <td colspan="2"><strong>$<?php echo htmlspecialchars(number_format($total, 2), ENT_QUOTES, 'UTF-8'); ?></strong></td>
                </tr>
            </table>

            <form method="post" action="cart_clear.php">
                <p><button type="submit">Clear Cart</button></p>
            </form>
        <?php endif; ?>
    </main>
</body>
</html>
