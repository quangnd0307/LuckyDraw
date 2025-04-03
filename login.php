<?php
session_start();
include 'db_connect.php'; // Kết nối database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn kiểm tra người dùng
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { width: 30%; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; margin-top: 50px; }
        input { width: 100%; padding: 8px; margin: 8px 0; }
        button { background: #007bff; color: white; border: none; padding: 10px; width: 100%; cursor: pointer; margin-top: 10px; }
        button:hover { background: #0056b3; }
        .error { color: red; }
        .register-link { margin-top: 15px; display: block; }
    </style>
</head>
<body>

<div class="container">
    <h2>Đăng Nhập</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <label>Tên đăng nhập</label>
        <input type="text" name="username" required>

        <label>Mật khẩu</label>
        <input type="password" name="password" required>

        <button type="submit">Log In</button>
    </form>

    <a href="register.php" class="register-link">Chưa có tài khoản? Đăng ký ngay</a>
</div>

</body>
</html>
