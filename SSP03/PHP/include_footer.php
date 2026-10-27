<?php
/* include_footer.php - SSP03 */

$tz = new DateTimeZone('America/Chicago');
$mod = new DateTime('@' . filemtime($_SERVER['SCRIPT_FILENAME']));
$mod->setTimezone($tz);
?>
    </main>
    <footer>
        <p>
            Last modified:
            <?php echo htmlspecialchars($mod->format('F j, Y, g:i a'), ENT_QUOTES, 'UTF-8'); ?>
        </p>
        <p>
            Disclaimer: Oklahoma City Community College does not necessarily
            endorse the content or the respective links of this web page.
        </p>
    </footer>
</body>
</html>