<?php
$servername = "localhost";  // Địa chỉ server (mặc định là localhost)
$username = "root";         // Tên user (mặc định trong XAMPP là root)
$password = "";             // Mật khẩu (mặc định trong XAMPP là rỗng)
$database = "diemsodaihoc"; // Tên database

// Kết nối MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
} else {
    echo "Kết nối thành công!";
}
?>