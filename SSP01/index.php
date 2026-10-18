<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Johnston, Kaden">
    <meta name="description" content="CS2623 Server-Side Programming - SSP01">
    <meta name="keywords" content="PHP, server-side, CS2623, OCCC">
    <title>CS2623 SSP01: Johnston</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <header>
        <h1>CS2623 Server-Side Programming</h1>
    </header>

    <nav id="top-nav">
        <a href="../SSP01/index.php">Home</a>
        <a href="../SSP02/SSP02.php">SSP02</a>
        <!-- SSP03 through SSP12 -->
    </nav>

    <main>
        <p>Hello World (HTML)</p>
        <?php echo htmlspecialchars('<p>Hello World (PHP Testing)</p>', ENT_QUOTES, 'UTF-8'); ?>
    </main>

    <footer>
        <p>
            Disclaimer: Oklahoma City Community College does not necessarily
            endorse the content or the respective links of this web page.
        </p>
    </footer>
</body>
</html>