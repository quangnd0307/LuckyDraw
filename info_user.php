<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["hinh_anh"])) {
    $target_dir = "avatar/";
    $target_file = $target_dir . basename($_FILES["hinh_anh"]["name"]);
    
    if (move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $target_file)) {
        // Cập nhật đường dẫn ảnh vào database
        $sql_update = "UPDATE users SET hinh_anh = ? WHERE username = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ss", $_FILES["hinh_anh"]["name"], $username);
        $stmt_update->execute();
    }
}

// Truy vấn thông tin người dùng
$sql = "SELECT full_name, email, phone, hinh_anh FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$avatar = !empty($row['hinh_anh']) ? "" . $row['hinh_anh'] : "http://localhost/avatar/default_avatar.png";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập Nhật Thông Tin</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; text-align: center; margin: 20px; }
        .container {
            width: 50%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid #007bff;
            display: block;
            margin: 10px auto;
        }
        .info {
            text-align: left;
            margin-top: 10px;
        }
        .info p { font-size: 16px; margin: 8px 0; }
        .info strong { color: #007bff; }
        .file-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .file-upload input { display: none; }
        .file-upload label {
            padding: 8px 15px;
            background: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .file-upload label:hover { background: #0056b3; }
        .save-btn {
            margin-top: 10px;
            padding: 8px 15px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: none;
        }
        .save-btn:hover { background: #218838; }
        .back-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 15px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .back-btn:hover { background: #0056b3; }
    </style>
</head>
<body>

<h2>Thông Tin Người Dùng</h2>

<div class="container">
    <img id="avatarPreview" src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar" class="avatar">
    
    <form method="POST" enctype="multipart/form-data">
        <div class="file-upload">
            <label for="hinh_anh">Chọn ảnh đại diện</label>
            <input type="file" name="hinh_anh" id="hinh_anh" accept="image/*" onchange="previewAvatar(event)">
        </div>
        <button type="submit" class="save-btn" id="saveBtn">Lưu</button>
    </form>

    <div class="info">
        <p><strong>Họ và Tên:</strong> <?php echo htmlspecialchars($row['full_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
        <p><strong>Số Điện Thoại:</strong> <?php echo htmlspecialchars($row['phone']); ?></p>
    </div>
</div>

<a href="index.php" class="back-btn">Quay lại</a>

<script>
    function previewAvatar(event) {
        var output = document.getElementById('avatarPreview');
        output.src = URL.createObjectURL(event.target.files[0]);
        document.getElementById('saveBtn').style.display = 'block';
    }
</script>

</body>
</html>