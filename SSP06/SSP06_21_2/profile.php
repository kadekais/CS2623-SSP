<?php

// profile.php - second protected page
require __DIR__ . '/auth.php';

$login_time = new DateTime('@' . (int) $_SESSION['login_at']);
$login_time->setTimezone(new DateTimeZone('America/Chicago'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS2623 SSP06 Profile: Johnston</title>
    <link rel="stylesheet" href="../../SSP01/main.css">
</head>
<body>
    <header>
        <h1>Profile: <?php echo htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8'); ?></h1>
    </header>
    <main>
        <p>Username:
            <?php echo htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p>Session started:
            <?php echo htmlspecialchars($login_time->format('F j, Y, g:i A'), ENT_QUOTES, 'UTF-8'); ?></p>
        <p><a href="dashboard.php">Back to dashboard</a> |
            <a href="logout.php">Log out</a></p>
    </main>
</body>
</html>
