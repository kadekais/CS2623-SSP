<?php

// ssp05_2 - exercise 7-2 product order form
// apollo is php 5.5 so no strict_types and no ??

// turns null or false from filter_input into a default
function clean($value, $default)
{
    return ($value === null || $value === false) ? $default : $value;
}

// check if the form was submitted
$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
if ($method === null) {
    // backup in case the server doesn't fill INPUT_SERVER
    $method = $_SERVER['REQUEST_METHOD'];
}

if ($method === 'POST') {
    // get the form data
    $cust_name = clean(filter_input(INPUT_POST, 'cust_name'), '');
    $product = clean(filter_input(INPUT_POST, 'product'), '');

    // quantity has to be a whole number, 1 or more
    $quantity = filter_input(
        INPUT_POST,
        'quantity',
        FILTER_VALIDATE_INT,
        array('options' => array('min_range' => 1))
    );
    $payment = clean(filter_input(INPUT_POST, 'payment'), 'none');
    $instructions = clean(filter_input(INPUT_POST, 'instructions'), '');

    // checkboxes come in as an array, needs FILTER_REQUIRE_ARRAY
    $options = filter_input(
        INPUT_POST,
        'options',
        FILTER_SANITIZE_SPECIAL_CHARS,
        FILTER_REQUIRE_ARRAY
    );
    // nothing checked gives null, so make it an empty array
    // so the foreach below doesn't break
    if (!is_array($options)) {
        $options = array();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS2623 SSP05_2: Johnston</title>
    <link rel="stylesheet" href="../../SSP01/main.css">
</head>
<body>
    <main>
        <h1>Exercise 7-2: Product Order Form</h1>

        <form method="post">
            <p>
                <label>Customer name:
                    <input type="text" name="cust_name" required>
                </label>
            </p>
            <p>
                <label>Product:
                    <select name="product">
                        <option value="Keyboard ($49.99)">Keyboard ($49.99)</option>
                        <option value="Mouse ($24.99)">Mouse ($24.99)</option>
                        <option value="Monitor ($179.99)">Monitor ($179.99)</option>
                        <option value="Headset ($59.99)">Headset ($59.99)</option>
                    </select>
                </label>
            </p>
            <p>
                <label>Quantity:
                    <input type="text" name="quantity" value="1">
                </label>
            </p>
            <p>
                Options:
                <label><input type="checkbox" name="options[]" value="Gift wrap"> Gift wrap</label>
                <label><input type="checkbox" name="options[]" value="Express ship"> Express ship</label>
                <label><input type="checkbox" name="options[]" value="Insurance"> Insurance</label>
            </p>
            <p>
                <label>Special instructions:<br>
                    <textarea name="instructions" rows="4" cols="50"></textarea>
                </label>
            </p>
            <p>
                Payment:
                <label><input type="radio" name="payment" value="credit"> Credit</label>
                <label><input type="radio" name="payment" value="debit"> Debit</label>
                <label><input type="radio" name="payment" value="paypal"> PayPal</label>
            </p>
            <p><input type="submit" value="Place order"></p>
        </form>

        <?php // only show the summary after the form is submitted ?>
        <?php if ($method === 'POST'): ?>
            <h2>Order Summary</h2>
            <p><strong>Customer:</strong>
                <?php echo htmlspecialchars($cust_name, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Product:</strong>
                <?php echo htmlspecialchars($product, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Quantity:</strong>
                <?php echo htmlspecialchars($quantity ? (string) $quantity : '(invalid)', ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Payment:</strong>
                <?php echo htmlspecialchars($payment, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Selected Options:</strong></p>
            <ul>
                <?php // one list item for each checked box ?>
                <?php foreach ($options as $opt): ?>
                    <li><?php echo htmlspecialchars($opt, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
            <p><strong>Instructions:</strong><br>
                <?php // htmlspecialchars first, then nl2br ?>
                <?php echo nl2br(htmlspecialchars($instructions, ENT_QUOTES, 'UTF-8')); ?></p>
        <?php endif ?>
    </main>
</body>
</html>