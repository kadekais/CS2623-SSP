<?php

// auth.php - require this at the top of every protected page
// apollo is php 5.5 so no strict_types

// only start the session if it isn't running already,
// starting it twice gives a notice
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    // this path goes through SSP06_21_2 so it works from the cart folder too
    header('Location: ../SSP06_21_2/login.php');
    exit;
}
