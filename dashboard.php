<?php
session_start();
require 'config.php';

// بررسی اینکه کاربر وارد شده باشد
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// گرفتن اطلاعات کاربر وارد شده از دیتابیس
// $stmt = $pdo->prepare("SELECT id, username, last_login FROM users WHERE id = ?");
// $stmt->execute([$_SESSION['user_id']]);
// $user = $stmt->fetch();

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    echo "کاربر یافت نشد!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>داشبورد</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/72d72acd48.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="user">
            <h1><?php echo htmlspecialchars($user['username']); ?></h1>
            <i class="fa-solid fa-user"></i>
        </div>
        <h2>Your Information</h2>
        <table>
            <thead>
                <tr>
                    <th>شناسه</th>
                    <th>نام کاربری</th>
                    <th>ایمیل</th>
                    <th>زمان ورود</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo date('Y-m-d H:i:s'); ?></td>
                </tr>
            </tbody>
        </table>

        <a href="logout.php" class="btn logout">Log Out</a>
    </div>
   
</body>
</html>
