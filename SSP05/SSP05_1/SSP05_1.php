<?php

// ssp05_1 - exercise 7-1 personal info form
// apollo is php 5.5 so no strict_types and no ??

// filter_input gives null if the field is missing
// and false if the filter fails
// this turns those into a default, same job as ??
function clean($value, $default)
{
    return ($value === null || $value === false) ? $default : $value;
}

// check if the form was submitted
$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
if ($method === null) {
    // backup in case the server doesn't fill INPUT_SERVER
    $method = $_SERVER['REQUEST_METHOD'];
}

if ($method === 'POST') {
    // get the form data
    $first = clean(filter_input(INPUT_POST, 'first_name'), '');
    $last = clean(filter_input(INPUT_POST, 'last_name'), '');
    $email = clean(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL), '');
    $age = clean(filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT), '');
    $gender = clean(filter_input(INPUT_POST, 'gender'), 'not specified');
    $country = clean(filter_input(INPUT_POST, 'country'), '');
    $comments = clean(filter_input(INPUT_POST, 'comments'), '');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS2623 SSP05_1: Johnston</title>
    <link rel="stylesheet" href="../../SSP01/main.css">
</head>
<body>
    <main>
        <h1>Exercise 7-1: Personal Info Form</h1>

        <form method="post">
            <p>
                <label>First name:
                    <input type="text" name="first_name" required>
                </label>
            </p>
            <p>
                <label>Last name:
                    <input type="text" name="last_name" required>
                </label>
            </p>
            <p>
                <label>Email:
                    <input type="text" name="email">
                </label>
            </p>
            <p>
                <label>Age:
                    <input type="text" name="age">
                </label>
            </p>
            <p>
                Gender:
                <label><input type="radio" name="gender" value="male"> Male</label>
                <label><input type="radio" name="gender" value="female"> Female</label>
                <label><input type="radio" name="gender" value="other"> Other</label>
            </p>
            <p>
                <label>Country:
                    <select name="country">
                        <option value="United States">United States</option>
                        <option value="Canada">Canada</option>
                        <option value="Mexico">Mexico</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="Japan">Japan</option>
                    </select>
                </label>
            </p>
            <p>
                <label>Comments:<br>
                    <textarea name="comments" rows="4" cols="50"></textarea>
                </label>
            </p>
            <p><input type="submit" value="Submit"></p>
        </form>

        <?php // only show results after the form is submitted ?>
        <?php if ($method === 'POST'): ?>
            <h2>Submitted Information</h2>
            <p><strong>Name:</strong>
                <?php echo htmlspecialchars($first . ' ' . $last, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Email:</strong>
                <?php echo htmlspecialchars($email !== '' ? $email : '(invalid)', ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Age:</strong>
                <?php echo htmlspecialchars($age !== '' ? (string) $age : '(invalid)', ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Gender:</strong>
                <?php echo htmlspecialchars($gender, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Country:</strong>
                <?php echo htmlspecialchars($country, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Comments:</strong><br>
                <?php // htmlspecialchars first, then nl2br ?>
                <?php echo nl2br(htmlspecialchars($comments, ENT_QUOTES, 'UTF-8')); ?></p>
        <?php endif; ?>
    </main>
</body>
</html>