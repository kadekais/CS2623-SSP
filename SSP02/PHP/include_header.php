<?php
/* include_header.php — CS2623 SSP02 */

if (isset($_SERVER["SERVER_NAME"])) {
    $server_name = $_SERVER["SERVER_NAME"];
} else {
    $server_name = "Server-Side Programming";
}
?>

<header>
    <h1>CS2623 <?php echo htmlspecialchars($server_name); ?></h1>
</header>