<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["csv_file"]) && $_FILES["csv_file"]["error"] == 0) {
        $file = $_FILES["csv_file"]["tmp_name"];
        $handle = fopen($file, "r");

        if ($handle !== false) {
            // Bỏ qua dòng tiêu đề
            $header = fgetcsv($handle, 1000, ",");
            if (count($header) != 10) {
                $_SESSION['message'] = "⚠️ File CSV không đúng định dạng! Hãy kiểm tra số cột.";
                fclose($handle);
                header("Location: form_csv.php");
                exit();
            }

            $errors = [];
            $success = 0;

            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if (count($data) != 10) {
                    $errors[] = "⚠️ Lỗi dòng " . ($success + 2) . ": Dữ liệu không đủ cột.";
                    continue;
                }

                list($ma_mon, $mon_hoc, $so_tinh_chi, $diem_chuyen_can, $diem_kiem_tra, $diem_thi, 
                    $he_so_10, $he_so_4, $diem_chu, $date_cap_nhat) = $data;

                // Kiểm tra dữ liệu có rỗng không
                if (empty($ma_mon) || empty($mon_hoc) || empty($so_tinh_chi) || empty($date_cap_nhat)) {
                    $errors[] = "⚠️ Lỗi dòng " . ($success + 2) . ": Một số trường bắt buộc bị thiếu.";
                    continue;
                }

                // Kiểm tra định dạng số
                if (!is_numeric($so_tinh_chi) || !is_numeric($diem_chuyen_can) || 
                    !is_numeric($diem_kiem_tra) || !is_numeric($diem_thi) || 
                    !is_numeric($he_so_10) || !is_numeric($he_so_4)) {
                    $errors[] = "⚠️ Lỗi dòng " . ($success + 2) . ": Điểm phải là số.";
                    continue;
                }

                // Kiểm tra định dạng ngày tháng
                $date_format = DateTime::createFromFormat('Y-m-d', $date_cap_nhat);
                if (!$date_format) {
                    $errors[] = "⚠️ Lỗi dòng " . ($success + 2) . ": Ngày không đúng định dạng YYYY-MM-DD.";
                    continue;
                }

                // Chuẩn bị câu lệnh SQL
                $sql = "INSERT INTO diemso (ma_mon, mon_hoc, so_tinh_chi, diem_chuyen_can, diem_kiem_tra, diem_thi, 
                        he_so_10, he_so_4, diem_chu, date_cap_nhat) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssiiiddsss", $ma_mon, $mon_hoc, $so_tinh_chi, $diem_chuyen_can, 
                                  $diem_kiem_tra, $diem_thi, $he_so_10, $he_so_4, $diem_chu, $date_cap_nhat);

                // Thực thi câu lệnh
                if ($stmt->execute()) {
                    $success++;
                } else {
                    $errors[] = "⚠️ Lỗi dòng " . ($success + 2) . ": Lỗi nhập dữ liệu vào database.";
                }
            }
            fclose($handle);

            if (!empty($errors)) {
                $_SESSION['message'] = implode("<br>", $errors);
            } else {
                $_SESSION['message'] = "✅ Đã nhập thành công $success dòng dữ liệu!";
            }
        } else {
            $_SESSION['message'] = "❌ Không thể mở file CSV!";
        }
    } else {
        $_SESSION['message'] = "❌ Chưa chọn file hoặc file có lỗi!";
    }
}

header("Location: form_csv.php");
exit();
?>
