<?php
include "db_connect.php"; // Kết nối đến MySQL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $ma_mon = $_POST["ma_mon"];
    $mon_hoc = $_POST["mon_hoc"];
    $so_tinh_chi = $_POST["so_tinh_chi"];
    $diem_chuyen_can = $_POST["diem_chuyen_can"];
    $diem_kiem_tra = $_POST["diem_kiem_tra"];
    $diem_thi = $_POST["diem_thi"];
    $he_so_10 = $_POST["he_so_10"];
    $he_so_4 = $_POST["he_so_4"];
    $diem_chu = $_POST["diem_chu"];
    $date_cap_nhat = date("Y-m-d H:i:s"); // Thời gian cập nhật

    // Câu lệnh SQL để chèn dữ liệu vào bảng diemso
    $sql = "INSERT INTO diemso (ma_mon, mon_hoc, so_tinh_chi, diem_chuyen_can, diem_kiem_tra, diem_thi, he_so_10, he_so_4, diem_chu, date_cap_nhat)
            VALUES ('$ma_mon', '$mon_hoc', '$so_tinh_chi', '$diem_chuyen_can', '$diem_kiem_tra', '$diem_thi', '$he_so_10', '$he_so_4', '$diem_chu', '$date_cap_nhat')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Thêm điểm thành công!');
                window.location.href = 'form.php'; // Quay lại trang nhập liệu
              </script>";
    } else {
        echo "<script>
                alert('Lỗi: " . $conn->error . "');
                window.location.href = 'form.php';
              </script>";
    }
}

$conn->close();
?>