<?php
function uploadImage($file, $destinationDir = './public/src/uploads')
{
    // Kiểm tra và validate ảnh
    $validationError = validateImage($file);
    if ($validationError !== null) {
        return ['status' => 'error', 'message' => $validationError];
    }

    if (!file_exists($destinationDir)) {
        if (!mkdir($destinationDir, 0755, true)) {
            return ['status' => 'error', 'message' => "Không thể tạo thư mục đích: $destinationDir."];
        }
    }


    // $currentDir = dirname(__FILE__);
    // echo "Thư mục chứa file hiện tại là: " . $currentDir;
    // echo "<br>";
    // Lấy thời gian hiện tại
    $timestamp = time();

    // Tạo tên file duy nhất để tránh ghi đè
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $uniqueFileName = uniqid('image_') . '_' . $timestamp . '.' . $fileExtension;
    $destinationPath = $destinationDir . '/' . $uniqueFileName;

    // Di chuyển file từ thư mục tạm đến thư mục đích
    if (!move_uploaded_file($file['tmp_name'], $destinationPath)) {
        return ['status' => 'error', 'message' => "Không thể di chuyển file đến thư mục đích."];
    }

    // Trả về tên file đã được upload
    return ['status' => 'success', 'file_name' => $uniqueFileName];
}

function deleteImage($fileName, $destinationDir = './public/src/uploads')
{
    // Tạo đường dẫn đầy đủ đến file cần xóa
    $filePath = $destinationDir . '/' . $fileName;

    // Kiểm tra xem file có tồn tại không
    if (!file_exists($filePath)) {
        return ['status' => 'error', 'message' => "File không tồn tại: $filePath"];
    }

    // Thực hiện xóa file
    if (unlink($filePath)) {
        return ['status' => 'success', 'message' => "File đã được xóa: $fileName"];
    } else {
        return ['status' => 'error', 'message' => "Không thể xóa file: $fileName"];
    }
}


?>