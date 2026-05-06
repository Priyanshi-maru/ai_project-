<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($check->num_rows > 0) {
        $error = "Username already exists!";
    } else {
        $conn->query("INSERT INTO users (username, password) VALUES ('$username', '$password')");
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - AI Quiz Generator</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-container">
            <h1>Create an Account</h1>
            <p>Sign up to generate AI quizzes instantly</p>
            
            <?php if(isset($error)) echo "<div class='error-msg'>$error</div>"; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Choose a username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Create a password" required>
                </div>
                <button type="submit">Register</button>
            </form>
            
            <p style="margin-top: 25px; margin-bottom: 0;">
                Already have an account? <a href="login.php">Log in here</a>
            </p>
        </div>
    </div>
</body>
</html>
