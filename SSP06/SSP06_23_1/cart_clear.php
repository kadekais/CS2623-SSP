<?php

// cart_clear.php - empties the cart then goes back to the catalog
require __DIR__ . '/../SSP06_21_2/auth.php';

// only clear on a POST so a plain link or page preload can't empty the cart
$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
if ($method === null) {
    $method = $_SERVER['REQUEST_METHOD'];
}

if ($method === 'POST') {
    unset($_SESSION['cart']);
}

header('Location: index.php');
exit;
