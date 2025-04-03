<?php
session_start();
include 'db_connect.php';

// Kiểm tra nếu chưa đăng nhập thì chuyển hướng về login.php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$role_id = $_SESSION['role_id']; // Lấy role ID từ session

// Truy vấn để lấy hình ảnh của người dùng
$sql = "SELECT hinh_anh FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$avatar = !empty($row['hinh_anh']) ? "upload/" . $row['hinh_anh'] : "default_avatar.png";

// Truy vấn danh sách sinh viên
$sql_students = "SELECT id, full_name FROM users";
$result_students = $conn->query($sql_students);

// Truy vấn phân quyền
//$sql = "SELECT can_edit, can_delete FROM role_permissions WHERE role_id = ? AND table_name = 'diemso'";
//$stmt = $conn->prepare($sql);
//$stmt->bind_param("i", $role_id);
//$stmt->execute();
//$permissions = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng Điểm</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
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
            width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;
        }
        .logout-btn {
            background: red; color: white; padding: 8px 12px; text-decoration: none; border-radius: 4px;
        }
        .logout-btn:hover { background: darkred; }
        table {
            width: 100%; border-collapse: collapse; margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd; padding: 8px; text-align: center;
        }
        th { background: #007bff; color: white; }
        .edit-btn, .delete-btn {
            padding: 5px 10px; border: none; cursor: pointer; color: white; border-radius: 4px; text-decoration: none;
        }
        .edit-btn { background: #28a745; }
        .edit-btn:hover { background: #218838; }
        .delete-btn { background: #dc3545; }
        .delete-btn:hover { background: #c82333; }
    </style>
</head>
<body>
<!-- Thanh header với Avatar và Log Out -->
<div class="header">
    <div class="user-info">
        <img src="<?php echo htmlspecialchars($avatar); ?>" alt="User Avatar">
        <span>Xin chào, <?php echo htmlspecialchars($username); ?>!</span>
    </div>
    <a href="logout.php" class="logout-btn">Log Out</a>
</div>

<h2 style="text-align: center;">Nhập Điểm</h2>

<!-- Form nhập điểm -->
<form action="update.php" method="post">
    <label for="id_user">Chọn Sinh Viên:</label>
    <select name="id_user" id="id_user" required>
        <option value="">-- Chọn Sinh Viên --</option>
        <?php while ($student = $result_students->fetch_assoc()) { ?>
            <option value="<?php echo $student['id']; ?>">
                <?php echo htmlspecialchars($student['full_name']); ?>
            </option>
        <?php } ?>
    </select>
    
    <!-- Các trường nhập điểm giữ nguyên -->
    <label for="ma_mon">Mã Môn:</label>
    <input type="text" name="ma_mon" required>
    
    <label for="mon_hoc">Môn Học:</label>
    <input type="text" name="mon_hoc" required>
    
    <label for="so_tinh_chi">Số Tín Chỉ:</label>
    <input type="number" name="so_tinh_chi" required>
    
    <label for="diem_chuyen_can">Điểm Chuyên Cần:</label>
    <input type="number" name="diem_chuyen_can" step="0.01" required>
    
    <label for="diem_kiem_tra">Điểm Kiểm Tra:</label>
    <input type="number" name="diem_kiem_tra" step="0.01" required>
    
    <label for="diem_thi">Điểm Thi:</label>
    <input type="number" name="diem_thi" step="0.01" required>
    
    <button type="submit" class="edit-btn">Lưu</button>
    <a href="index.php" class="delete-btn">Hủy</a>
</form>
</body>
</html>