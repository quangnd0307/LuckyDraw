<?php
include "db_connect.php"; // Kết nối database

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM diemso WHERE ma_mon='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Xóa thành công!');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>