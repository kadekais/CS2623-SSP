<?php

// ssp07 ex 15-1 - regex validation and exceptions
// apollo is php 5.5 so no strict_types, no ?? and no return types

class ValidationException extends RuntimeException
{
}

class FormatException extends ValidationException
{
}

class DatabaseException extends RuntimeException
{
}

// gets a value from an array or gives '' if it's missing, same job as ??
function field($data, $key)
{
    return isset($data[$key]) ? $data[$key] : '';
}

function validateContact(array $data)
{
    $errors = [];
    $format_error = false;

    // email, use filter_var and not my own regex
    if (!filter_var(field($data, 'email'), FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    }

    // website url
    if (!filter_var(field($data, 'website'), FILTER_VALIDATE_URL)) {
        $errors[] = 'Invalid website URL (start with http:// or https://).';
    }

    // age has to be a whole number, filter_var gives false if it isn't
    $age = filter_var(
        field($data, 'age'),
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1, 'max_range' => 120]]
    );
    if ($age === false) {
        $errors[] = 'Age must be a whole number from 1 to 120.';
    }

    // phone, filter_var has no phone check so use preg_match
    if (!preg_match('/^\d{3}-\d{3}-\d{4}$/', field($data, 'phone'))) {
        $errors[] = 'Phone must be in format 555-555-5555.';
    }

    // zip code
    if (!preg_match('/^\d{5}(-\d{4})?$/', field($data, 'zip'))) {
        $errors[] = 'ZIP must be 5 digits or ZIP+4 (like 74103 or 74103-1234).';
    }

    // product code, 2 capital letters then 4 digits
    if (!preg_match('/^[A-Z]{2}\d{4}$/', field($data, 'product_code'))) {
        $errors[] = 'Product code must be 2 capital letters and 4 digits (like AB1234).';
        $format_error = true;
    }

    if ($errors) {
        // product code problem gets its own exception class
        if ($format_error) {
            throw new FormatException(implode(' | ', $errors));
        }
        throw new ValidationException(implode(' | ', $errors));
    }

    return $data;
}

$keys = ['email', 'website', 'age', 'phone', 'zip', 'product_code', 'message'];
$form = array_fill_keys($keys, '');
$result = null;
$errMsg = '';

// check if the form was submitted
$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
if ($method === null) {
    // backup in case the server doesn't fill INPUT_SERVER
    $method = $_SERVER['REQUEST_METHOD'];
}

if ($method === 'POST') {
    // read the raw values, they get escaped when displayed
    foreach ($keys as $key) {
        $value = filter_input(INPUT_POST, $key);
        $form[$key] = ($value === null || $value === false) ? '' : trim($value);
    }

    try {
        $result = validateContact($form);
    } catch (FormatException $e) {
        // most specific first
        $errMsg = 'Format problem: ' . $e->getMessage();
    } catch (ValidationException $e) {
        $errMsg = $e->getMessage();
    } catch (RuntimeException $e) {
        // broadest last
        $errMsg = 'System error: ' . $e->getMessage();
    } finally {
        // runs every time, good for logging
        $now = new DateTime('now', new DateTimeZone('America/Chicago'));
        error_log('Contact form processed at ' . $now->format('Y-m-d H:i:s'));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS2623 SSP07 Ex 15-1: Johnston</title>
    <link rel="stylesheet" href="../../SSP01/main.css">
</head>
<body>
    <main>
        <h1>Contact Form Validation</h1>

        <?php if ($errMsg !== ''): ?>
            <div class="error">
                <strong><?php echo htmlspecialchars($errMsg, ENT_QUOTES, 'UTF-8'); ?></strong>
            </div>
        <?php endif; ?>

        <?php if ($result): ?>
            <p>All fields valid, ready to save.</p>
            <ul>
                <li>Email: <?php echo htmlspecialchars($result['email'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li>Website: <?php echo htmlspecialchars($result['website'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li>Age: <?php echo htmlspecialchars($result['age'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li>Phone: <?php echo htmlspecialchars($result['phone'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li>ZIP: <?php echo htmlspecialchars($result['zip'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li>Product code: <?php echo htmlspecialchars($result['product_code'], ENT_QUOTES, 'UTF-8'); ?></li>
            </ul>
            <p><strong>Message:</strong><br>
                <?php // htmlspecialchars first, then nl2br ?>
                <?php echo nl2br(htmlspecialchars($result['message'], ENT_QUOTES, 'UTF-8')); ?></p>
        <?php endif; ?>

        <form method="post">
            <p>
                <label>Email:
                    <input type="text" name="email"
                        value="<?php echo htmlspecialchars($form['email'], ENT_QUOTES, 'UTF-8'); ?>">
                </label>
            </p>
            <p>
                <label>Website:
                    <input type="text" name="website"
                        value="<?php echo htmlspecialchars($form['website'], ENT_QUOTES, 'UTF-8'); ?>">
                </label>
            </p>
            <p>
                <label>Age:
                    <input type="text" name="age"
                        value="<?php echo htmlspecialchars($form['age'], ENT_QUOTES, 'UTF-8'); ?>">
                </label>
            </p>
            <p>
                <label>Phone (555-555-5555):
                    <input type="text" name="phone"
                        value="<?php echo htmlspecialchars($form['phone'], ENT_QUOTES, 'UTF-8'); ?>">
                </label>
            </p>
            <p>
                <label>ZIP:
                    <input type="text" name="zip"
                        value="<?php echo htmlspecialchars($form['zip'], ENT_QUOTES, 'UTF-8'); ?>">
                </label>
            </p>
            <p>
                <label>Product code (AB1234):
                    <input type="text" name="product_code"
                        value="<?php echo htmlspecialchars($form['product_code'], ENT_QUOTES, 'UTF-8'); ?>">
                </label>
            </p>
            <p>
                <label>Message:<br>
                    <textarea name="message" rows="4" cols="40"><?php echo htmlspecialchars($form['message'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                </label>
            </p>
            <p><button type="submit">Validate</button></p>
        </form>
    </main>
</body>
</html>
