<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhập điểm từ CSV</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }
        h2 {
            color: #007bff;
            margin-bottom: 15px;
        }
        .upload-box {
            border: 2px dashed #007bff;
            padding: 20px;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s ease;
            display: block;
        }
        .upload-box:hover {
            background: #f0f8ff;
        }
        input[type="file"] {
            display: none;
        }
        .btn-upload {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            transition: background 0.3s ease;
        }
        .btn-upload:hover {
            background: #0056b3;
        }
        .file-name {
            margin-top: 10px;
            font-size: 14px;
            color: #333;
            font-weight: bold;
        }
        .message {
            margin-top: 10px;
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Nhập điểm từ CSV</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <p class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
    <?php endif; ?>

    <form action="upload_csv.php" method="post" enctype="multipart/form-data">
        <label for="csv_file" class="upload-box" id="file-label">
            📂 Kéo hoặc chọn file CSV
        </label>
        <input type="file" name="csv_file" id="csv_file" accept=".csv" required onchange="updateFileName()">
        <p class="file-name" id="file-name">Chưa có file nào được chọn</p>
        <button type="submit" class="btn-upload">📤 Tải lên</button>
    </form>
</div>

<script>
    function updateFileName() {
        var input = document.getElementById('csv_file');
        var fileName = input.files.length > 0 ? input.files[0].name : "Chưa có file nào được chọn";
        document.getElementById('file-name').textContent = "📄 " + fileName;
    }
</script>

</body>
</html>
