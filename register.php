<?php
include 'db_connect.php'; // Kết nối database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Mã hóa mật khẩu

    // Kiểm tra và xử lý upload hình ảnh
    $target_dir = "C:/xampp/htdocs/avatar/"; // Thư mục lưu ảnh trên server
    $file_name = time() . "_" . basename($_FILES["hinh_anh"]["name"]); // Đổi tên file tránh trùng
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra định dạng file ảnh hợp lệ
    $valid_extensions = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $valid_extensions)) {
        die("Chỉ chấp nhận file JPG, JPEG, PNG, GIF.");
    }

    // Di chuyển file vào thư mục avatar
    if (move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $target_file)) {
        $avatar_path = "http://localhost/avatar/" . $file_name; // Đường dẫn hợp lệ trên web

        // Chèn dữ liệu vào database sử dụng prepared statement để tránh SQL Injection
        $sql = "INSERT INTO users (username, password, hinh_anh) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $password, $avatar_path);
        
        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            echo "Lỗi: " . $stmt->error;
        }
    } else {
        echo "Lỗi khi tải ảnh lên.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { width: 30%; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; margin-top: 50px; }
        input { width: 100%; padding: 8px; margin: 8px 0; }
        button { background: #007bff; color: white; border: none; padding: 10px; width: 100%; cursor: pointer; margin-top: 10px; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>

<div class="container">
    <h2>Đăng Ký</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Tên đăng nhập</label>
        <input type="text" name="username" required>

        <label>Mật khẩu</label>
        <input type="password" name="password" required>

        <label>Chọn ảnh đại diện</label>
        <input type="file" name="hinh_anh" accept="image/*" required>

        <button type="submit">Đăng Ký</button>
    </form>
    <a href="login.php">Đã có tài khoản? Đăng nhập</a> 
</div>

</body>
</html>