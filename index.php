<?php
session_start();
include 'db_connect.php';

// Kiểm tra nếu chưa đăng nhập thì chuyển hướng về login.php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Truy vấn để lấy hình ảnh của người dùng
$sql = "SELECT hinh_anh FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$avatar = !empty($row['hinh_anh']) ? "" . $row['hinh_anh'] : "http://localhost/img/default_avatar.png";
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

<h2 style="text-align: center;">Bảng Điểm</h2>

<!-- Ô tìm kiếm -->
<input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Nhập từ khóa để tìm..." style="margin-bottom: 10px; padding: 5px; width: 20%;">

<!-- Button nhập điểm -->
<a href="form.php" class="edit-btn" style="margin-left: 10px;">Nhập Điểm</a>
<a href="form_csv.php" class="edit-btn" style="margin-left: 10px;">Imprort File</a>
<a href="info_user.php" class="edit-btn" style="margin-left: 10px;">Thông tin sinh viên</a>
<table id="scoreTable">
    <tr>
        <th>ID</th>
        <th>Mã Môn</th>
        <th>Môn Học</th>
        <th>Số Tín Chỉ</th>
        <th>Điểm Chuyên Cần</th>
        <th>Điểm Kiểm Tra</th>
        <th>Điểm Thi</th>
        <th>Hệ Số 10</th>
        <th>Hệ Số 4</th>
        <th>Điểm Chữ</th>
        <th>Ngày Cập Nhật</th>
        <th>Chỉnh Sửa</th>
        <th>Xóa</th>
    </tr>

    <?php
    $sql = "SELECT id, ma_mon, mon_hoc, so_tinh_chi, diem_chuyen_can, diem_kiem_tra, diem_thi, he_so_10, he_so_4, diem_chu, date_cap_nhat FROM diemso ORDER BY date_cap_nhat DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row['id'] . "</td>
                <td style='color:#0000FF; font-weight:bold;'>" . $row['ma_mon'] . "</td>
                <td>" . $row['mon_hoc'] . "</td>
                <td>" . $row['so_tinh_chi'] . "</td>
                <td>" . $row['diem_chuyen_can'] . "</td>
                <td>" . $row['diem_kiem_tra'] . "</td>
                <td>" . $row['diem_thi'] . "</td>
                <td>" . $row['he_so_10'] . "</td>
                <td>" . $row['he_so_4'] . "</td>
                <td>" . $row['diem_chu'] . "</td>
                <td>" . $row['date_cap_nhat'] . "</td>
                <td><a href='edit.php?id=" . $row['id'] . "' class='edit-btn'>📝 Sửa</a></td>
                <td><a href='delete.php?id=" . $row['id'] . "' class='delete-btn' onclick='return confirm(\'Xóa điểm này?\')'>Xóa</a></td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='13'>Không có dữ liệu</td></tr>";
    }
    ?>
</table>

<script>
function searchTable() {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toLowerCase();
    table = document.getElementById("scoreTable");
    tr = table.getElementsByTagName("tr");
    
    for (i = 1; i < tr.length; i++) {
        tr[i].style.display = "none";
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                }
            }
        }
    }
}
</script>
</body>
</html>
