<?php
include 'db_connect.php'; // Kết nối database

// Lấy ID từ URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Truy vấn dữ liệu theo ID
    $sql = "SELECT * FROM diemso WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy dữ liệu!";
        exit();
    }
} else {
    echo "Thiếu ID!";
    exit();
}

// Khi nhấn nút "Lưu Thay Đổi"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ma_mon = $_POST['ma_mon'];
    $mon_hoc = $_POST['mon_hoc'];
    $so_tinh_chi = $_POST['so_tinh_chi'];
    $diem_chuyen_can = $_POST['diem_chuyen_can'];
    $diem_kiem_tra = $_POST['diem_kiem_tra'];
    $diem_thi = $_POST['diem_thi'];
    $he_so_10 = $_POST['he_so_10'];
    $he_so_4 = $_POST['he_so_4'];
    $diem_chu = $_POST['diem_chu'];
    $date_cap_nhat = date("Y-m-d H:i:s");

    // Cập nhật dữ liệu vào database
    $sql = "UPDATE diemso SET 
                ma_mon='$ma_mon', mon_hoc='$mon_hoc', so_tinh_chi='$so_tinh_chi', 
                diem_chuyen_can='$diem_chuyen_can', diem_kiem_tra='$diem_kiem_tra', 
                diem_thi='$diem_thi', he_so_10='$he_so_10', he_so_4='$he_so_4', 
                diem_chu='$diem_chu', date_cap_nhat='$date_cap_nhat'
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Cập nhật thành công!'); window.location='index.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh Sửa Điểm</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 50%; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        h2 { text-align: center; }
        input, button { width: 100%; padding: 8px; margin: 8px 0; }
        button { background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .cancel-btn { background: red; }
    </style>
</head>
<body>

<div class="container">
    <h2>Chỉnh Sửa Điểm</h2>
    <form method="POST">
        <label>Mã Môn</label>
        <input type="text" name="ma_mon" value="<?php echo $row['ma_mon']; ?>" required>

        <label>Môn Học</label>
        <input type="text" name="mon_hoc" value="<?php echo $row['mon_hoc']; ?>" required>

        <label>Số Tín Chỉ</label>
        <input type="number" name="so_tinh_chi" value="<?php echo $row['so_tinh_chi']; ?>" required>

        <label>Điểm Chuyên Cần</label>
        <input type="number" step="0.1" name="diem_chuyen_can" value="<?php echo $row['diem_chuyen_can']; ?>" required>

        <label>Điểm Kiểm Tra</label>
        <input type="number" step="0.1" name="diem_kiem_tra" value="<?php echo $row['diem_kiem_tra']; ?>" required>

        <label>Điểm Thi</label>
        <input type="number" step="0.1" name="diem_thi" value="<?php echo $row['diem_thi']; ?>" required>

        <label>Hệ Số 10</label>
        <input type="number" step="0.1" name="he_so_10" value="<?php echo $row['he_so_10']; ?>" required>

        <label>Hệ Số 4</label>
        <input type="number" step="0.1" name="he_so_4" value="<?php echo $row['he_so_4']; ?>" required>

        <label>Điểm Chữ</label>
        <input type="text" name="diem_chu" value="<?php echo $row['diem_chu']; ?>" required>

        <button type="submit">Lưu Thay Đổi</button>
        <a href="index.php"><button type="button" class="cancel-btn">Hủy</button></a>
    </form>
</div>

</body>
</html>