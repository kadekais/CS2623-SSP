<?php

// login.php - self-processing login form

session_start();

$users = [
    'admin' => password_hash('secret123', PASSWORD_DEFAULT),
    'jsmith' => password_hash('php4life!', PASSWORD_DEFAULT),
];

$max_attempts = 3;
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

// the remember me cookie only fills in the username box, never logs anyone in
$remembered = filter_input(INPUT_COOKIE, 'remember_user');
$username = ($remembered === null || $remembered === false) ? '' : $remembered;
$remember_checked = ($username !== '');
$error = '';

// check if the form was submitted
$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
if ($method === null) {
    // backup in case the server doesn't fill INPUT_SERVER
    $method = $_SERVER['REQUEST_METHOD'];
}

if ($method === 'POST') {
    if ($_SESSION['attempts'] >= $max_attempts) {
        // locked, so don't even check the password
        $error = 'Too many failed attempts. Login is locked for this session.';
    } else {
        $posted_user = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        $remember = (filter_input(INPUT_POST, 'remember') === '1');

        // null or false means missing, so use empty strings
        $username = ($posted_user === null || $posted_user === false) ? '' : trim($posted_user);
        $password = ($password === null || $password === false) ? '' : $password;
        $remember_checked = $remember;

        if (isset($users[$username]) && password_verify($password, $users[$username])) {
            // new session id after login stops session fixation
            session_regenerate_id(true);
            $_SESSION['user'] = $username;
            $_SESSION['login_at'] = time();
            $_SESSION['attempts'] = 0;

            if ($remember) {
                // cookie holds the username only, 30 days, httponly
                setcookie('remember_user', $username, time() + (30 * 24 * 60 * 60), '/', '', false, true);
            } else {
                // delete the cookie
                setcookie('remember_user', '', time() - 3600, '/');
            }

            header('Location: dashboard.php');
            exit;
        }

        $_SESSION['attempts']++;
        if ($_SESSION['attempts'] >= $max_attempts) {
            $error = 'Too many failed attempts. Login is locked for this session.';
        } else {
            $left = $max_attempts - $_SESSION['attempts'];
            $error = 'Invalid username or password. Attempts left: ' . $left;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS2623 SSP06 Login: Johnston</title>
    <link rel="stylesheet" href="../../SSP01/main.css">
</head>
<body>
    <main>
        <h1>Login</h1>

        <?php if ($error !== ''): ?>
            <p><strong><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></strong></p>
        <?php endif; ?>

        <form method="post">
            <p>
                <label>Username:
                    <input type="text" name="username" autocomplete="username"
                        value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>">
                </label>
            </p>
            <p>
                <label>Password:
                    <input type="password" name="password" autocomplete="current-password">
                </label>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="remember" value="1"
                        <?php echo $remember_checked ? 'checked' : ''; ?>>
                    Remember me (30 days)
                </label>
            </p>
            <p><button type="submit">Log in</button></p>
        </form>
    </main>
</body>
</html>
