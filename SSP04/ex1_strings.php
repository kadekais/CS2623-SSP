<?php

$desc = 'The PHP Pro keyboard is fast.';
$price = 129.9;
$big = 1250000;

$rows = [
    ['str_replace()', $desc, str_replace('PHP', 'Code', $desc)],
    ['strpos()', 'PHP', strpos($desc, 'PHP') !== false ? 'true' : 'false'],
    ['strtolower()', $desc, strtolower($desc)],
    ['strtoupper()', $desc, strtoupper($desc)],
    ['strlen()', $desc, (string) strlen($desc)],
    ['sprintf()', (string) $price, sprintf('$%.2f', $price)],
    ['number_format()', (string) $big, number_format($big)],
    ['substr()', $desc, substr($desc, 0, 7)],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CS2623 SSP04 Ex1: Johnston</title>
    <link rel="stylesheet" href="../SSP01/main.css">
</head>
<body>
    <main>
        <p>
            Original string:
            <?php echo htmlspecialchars($desc, ENT_QUOTES, 'UTF-8'); ?>
        </p>
        <table border="1" cellpadding="6" cellspacing="0">
            <tr>
                <th>Function</th>
                <th>Input</th>
                <th>Output</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <?php foreach ($row as $cell) { ?>
                        <td><?php echo htmlspecialchars($cell, ENT_QUOTES, 'UTF-8'); ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
    </main>
</body>
</html>