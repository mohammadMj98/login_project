<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (strlen($password) < 8) {
        $error = "رمز عبور باید حداقل 8 کاراکتر باشد.";
    } else {
        // بررسی اینکه نام کاربری از قبل وجود نداشته باشد
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            $error = "این نام کاربری قبلاً ثبت شده است.";
        } else {
            // اضافه کردن کاربر به دیتابیس
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed_password]);
            header("Location: login.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>register</title>
    <link rel="stylesheet" href="./style.css">
    <script src="https://kit.fontawesome.com/72d72acd48.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="wrapper">
        <div class="formbox">
            <?php if (!empty($error)): ?>
                <p style="color:red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <h1>Register</h1>
            <form method="post">
                <div class="input-box">
                    <div class="icon">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <input type="text" name="username" required>
                    <label for="username">Username</label>
                </div>
                <div class="input-box">
                    <div class="icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <input type="email" name="email" required>
                    <label for="email">E-mail</label>
                </div>
                <div class="input-box">
                    <div class="icon">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input type="password" name="password" required>
                    <label for="password">Password</label>
                </div>
                <button type="submit" class="btn">Register</button>
                <p>Do you have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>
