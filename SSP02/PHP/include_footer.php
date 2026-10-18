<?php
/* include_footer.php - CS2623 SSP02 */

// Last-modified timestamp of the script being requested
$last_modified = date('F j, Y, g:i a', filemtime($_SERVER['SCRIPT_FILENAME']));
?>
<footer>
    <p>Last modified: <?php echo htmlspecialchars($last_modified, ENT_QUOTES, 'UTF-8'); ?></p>
    <p>
        Disclaimer: Oklahoma City Community College does not necessarily
        endorse the content or the respective links of this web page.
    </p>
</footer>