<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // دریافت کاربر از دیتابیس
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        // بررسی رمز عبور
        if (password_verify($password, $user['password'])) {
            // ذخیره اطلاعات کاربر در جلسه و هدایت به داشبورد
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "رمز عبور اشتباه است.";
        }
    } else {
        $error = "نام کاربری یافت نشد.";
    }
}
?>


<!DOCTYPE html>
<html lang="fa">
<head>
    <title>ورود</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/72d72acd48.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="wrapper">
        <div class="formbox">
            <?php if (!empty($error)): ?>
                <p style="color:red;"><?php echo $error; ?></p>
                <?php endif; ?>
                <h1>Login</h1>
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
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input type="text" name="password" required>
                            <label for="password">password</label>
                        </div>
                        <button type="submit" class="btn">Login</button>
                <p>Don't have an account ?<a href="register.php">Reigester</a></p>
            </form>
            
    </div>
</body>
</html>
