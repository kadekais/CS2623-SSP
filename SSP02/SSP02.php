<?php
/*
 * SSP02.php - CS2623 Week 1
 * Dynamic PHP page with include files.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Johnston, Kaden">
    <meta name="description" content="CS2623 Server-Side Programming - SSP02">
    <title>CS2623 SSP02: Johnston</title>
    <link rel="stylesheet" href="../SSP01/main.css">
    <link rel="stylesheet" href="CSS/table.css">
</head>
<body>
    <?php require_once __DIR__ . '/PHP/include_header.php'; ?>

    <div id="page-wrapper">
        <?php require_once __DIR__ . '/PHP/include_leftNav.php'; ?>

        <main>
            <?php require_once __DIR__ . '/PHP/include_topNav.php'; ?>
            <?php require_once __DIR__ . '/PHP/include_dynamic_content.php'; ?>
        </main>
    </div>

    <?php require_once __DIR__ . '/PHP/include_footer.php'; ?>
</body>
</html>