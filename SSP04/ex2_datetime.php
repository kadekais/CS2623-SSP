<?php

$tz = new DateTimeZone('America/Chicago');
$now = new DateTime('now', $tz);
$end_date = new DateTime('2026-12-15', $tz);
$left = $now->diff($end_date);
$birth = DateTime::createFromFormat('Y-m-d', '2003-05-16', $tz);
$age = $birth->diff($now);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CS2623 SSP04 Ex2: Johnston</title>
    <link rel="stylesheet" href="../SSP01/main.css">
</head>
<body>
    <main>
        <p>
            Today is:
            <?php echo htmlspecialchars($now->format('l, F j, Y'), ENT_QUOTES, 'UTF-8'); ?>
        </p>
        <p>
            Current time:
            <?php echo htmlspecialchars($now->format('g:i:s A'), ENT_QUOTES, 'UTF-8'); ?>
        </p>
        <p>
            Days until semester end:
            <?php echo htmlspecialchars((string) $left->days, ENT_QUOTES, 'UTF-8'); ?>
        </p>
        <p>
            Age in years:
            <?php echo htmlspecialchars((string) $age->y, ENT_QUOTES, 'UTF-8'); ?>
        </p>
        <p>
            Age in days:
            <?php echo htmlspecialchars((string) $age->days, ENT_QUOTES, 'UTF-8'); ?>
        </p>
    </main>
</body>
</html>