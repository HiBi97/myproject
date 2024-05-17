<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Attendance System - Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="auth.css">
</head>
<?php
$loginSuccess = false;
$userExists = false; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $xml = simplexml_load_file('users.xml');
    $userExists = false;

    // Check if username already exists
    foreach ($xml->user as $user) {
        if ($user->username == $username) {
            $userExists = true;
            break;
        }
    }

    if (!$userExists) {
        $newUser = $xml->addChild('user');
        $newUser->addChild('username', $username);
        $newUser->addChild('password', md5($password)); 
        $xml->asXML('users.xml');
        $loginSuccess = true;
    }
}
?>
<body>
    <div class="wrapper">
        <div class="logo text-center">
            <h1>School Attendance System</h1>
        </div>
        <div class="inner-warpper text-center">
            <h2 class="title">Register your account</h2>
            <form method="post">
                <div class="input-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Password" name="password" required>
                    <?php if ($loginSuccess): ?>
                    <span id="userPassword-success" class="validate-tooltip1">Account Registered Successfully</span>
                    <?php endif; ?>
                    <?php if ($userExists): ?>
                    <span id="userExists-error" class="validate-tooltip">Username already exists!</span>
                    <?php endif; ?>
                </div>
                <button type="submit" value="Register">Register</button>
            </form>
        </div>
        <div class="signup-wrapper text-center">
            <a href="login.php">Already have an account? <span class="text-primary">Login</span></a>
        </div>
    </div>
    <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js'></script>
    <script src="./script.js"></script>
</body>
</html>
