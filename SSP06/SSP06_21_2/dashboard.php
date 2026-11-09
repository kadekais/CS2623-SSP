<?php

// dashboard.php - protected page
// auth.php sends you to the login page if you're not logged in
require __DIR__ . '/auth.php';

// apollo runs UTC so show the login time in central time
$login_time = new DateTime('@' . (int) $_SESSION['login_at']);
$login_time->setTimezone(new DateTimeZone('America/Chicago'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS2623 SSP06 Dashboard: Johnston</title>
    <link rel="stylesheet" href="../../SSP01/main.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8'); ?>!</h1>
    </header>
    <main>
        <p>Logged in at:
            <?php echo htmlspecialchars($login_time->format('g:i A'), ENT_QUOTES, 'UTF-8'); ?></p>
        <ul>
            <li><a href="profile.php">My profile</a></li>
            <li><a href="../SSP06_23_1/index.php">Product catalog and cart</a></li>
            <li><a href="logout.php">Log out</a></li>
        </ul>
    </main>
</body>
</html>
