<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username']; // Lấy tên đăng nhập
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            background: #007bff;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .user-info {
            display: flex;
            align-items: center;
        }
        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .logout-btn {
            background: red;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
        }
        .logout-btn:hover {
            background: darkred;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="user-info">
        <img src="avatar.png" alt="User Avatar"> <!-- Thay ảnh avatar tại đây -->
        <span>Xin chào, <?php echo htmlspecialchars($username); ?>!</span>
    </div>
    <a href="logout.php" class="logout-btn">Log Out</a>
</div>

<!-- Phần nội dung trang giữ nguyên cấu trúc của bạn -->
<div class="content">
    <h1>Chào mừng đến với Trang Chủ</h1>
</div>

</body>
</html>
