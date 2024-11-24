<?php
function timeAgo($datetime, $full = false)
{
    // Đảm bảo múi giờ Việt Nam
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'năm',
        'm' => 'tháng',
        'w' => 'tuần',
        'd' => 'ngày',
        'h' => 'giờ',
        'i' => 'phút',
        's' => 'giây',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $output[] = $diff->$k . ' ' . $v;
        }
    }
    if (!$full)
        $output = array_slice($output, 0, 1);
    return $output ? implode(', ', $output) . ' trước' : 'vừa mới';
}
// Bỏ các hình trong bài viết tạo thành sort content
function stripImages($content)
{
    return preg_replace('/<img[^>]*>/i', '', $content);
}
// format thời gian
function formatVietnameseDate($dateString)
{
    $timestamp = strtotime($dateString);

    $formattedDate = 'Ngày ' . date('d', $timestamp) . ' tháng ' . date('m', $timestamp) . ', ' . date('Y', $timestamp);

    return $formattedDate;
}

function create_slug($string)
{
    // Mảng ký tự tiếng Việt có dấu
    $vietnamese = array(
        'à',
        'á',
        'ạ',
        'ả',
        'ã',
        'â',
        'ầ',
        'ấ',
        'ậ',
        'ẩ',
        'ẫ',
        'ă',
        'ằ',
        'ắ',
        'ặ',
        'ẳ',
        'ẵ',
        'è',
        'é',
        'ẹ',
        'ẻ',
        'ẽ',
        'ê',
        'ề',
        'ế',
        'ệ',
        'ể',
        'ễ',
        'ì',
        'í',
        'ị',
        'ỉ',
        'ĩ',
        'ò',
        'ó',
        'ọ',
        'ỏ',
        'õ',
        'ô',
        'ồ',
        'ố',
        'ộ',
        'ổ',
        'ỗ',
        'ơ',
        'ờ',
        'ớ',
        'ợ',
        'ở',
        'ỡ',
        'ù',
        'ú',
        'ụ',
        'ủ',
        'ũ',
        'ư',
        'ừ',
        'ứ',
        'ự',
        'ử',
        'ữ',
        'ỳ',
        'ý',
        'ỵ',
        'ỷ',
        'ỹ',
        'đ',
        'À',
        'Á',
        'Ạ',
        'Ả',
        'Ã',
        'Â',
        'Ầ',
        'Ấ',
        'Ậ',
        'Ẩ',
        'Ẫ',
        'Ă',
        'Ằ',
        'Ắ',
        'Ặ',
        'Ẳ',
        'Ẵ',
        'È',
        'É',
        'Ẹ',
        'Ẻ',
        'Ẽ',
        'Ê',
        'Ề',
        'Ế',
        'Ệ',
        'Ể',
        'Ễ',
        'Ì',
        'Í',
        'Ị',
        'Ỉ',
        'Ĩ',
        'Ò',
        'Ó',
        'Ọ',
        'Ỏ',
        'Õ',
        'Ô',
        'Ồ',
        'Ố',
        'Ộ',
        'Ổ',
        'Ỗ',
        'Ơ',
        'Ờ',
        'Ớ',
        'Ợ',
        'Ở',
        'Ỡ',
        'Ù',
        'Ú',
        'Ụ',
        'Ủ',
        'Ũ',
        'Ư',
        'Ừ',
        'Ứ',
        'Ự',
        'Ử',
        'Ữ',
        'Ỳ',
        'Ý',
        'Ỵ',
        'Ỷ',
        'Ỹ',
        'Đ'
    );

    // Mảng ký tự không dấu tương ứng
    $non_vietnamese = array(
        'a',
        'a',
        'a',
        'a',
        'a',
        'a',
        'a',
        'a',
        'a',
        'a',
        'a',
        'a',
        'a',
        'a',
        'a',
        'a',
        'a',
        'e',
        'e',
        'e',
        'e',
        'e',
        'e',
        'e',
        'e',
        'e',
        'e',
        'e',
        'i',
        'i',
        'i',
        'i',
        'i',
        'o',
        'o',
        'o',
        'o',
        'o',
        'o',
        'o',
        'o',
        'o',
        'o',
        'o',
        'o',
        'o',
        'o',
        'o',
        'o',
        'o',
        'u',
        'u',
        'u',
        'u',
        'u',
        'u',
        'u',
        'u',
        'u',
        'u',
        'u',
        'y',
        'y',
        'y',
        'y',
        'y',
        'd',
        'A',
        'A',
        'A',
        'A',
        'A',
        'A',
        'A',
        'A',
        'A',
        'A',
        'A',
        'A',
        'A',
        'A',
        'A',
        'A',
        'A',
        'E',
        'E',
        'E',
        'E',
        'E',
        'E',
        'E',
        'E',
        'E',
        'E',
        'E',
        'I',
        'I',
        'I',
        'I',
        'I',
        'O',
        'O',
        'O',
        'O',
        'O',
        'O',
        'O',
        'O',
        'O',
        'O',
        'O',
        'O',
        'O',
        'O',
        'O',
        'O',
        'O',
        'U',
        'U',
        'U',
        'U',
        'U',
        'U',
        'U',
        'U',
        'U',
        'U',
        'U',
        'Y',
        'Y',
        'Y',
        'Y',
        'Y',
        'D'
    );

    // Thay thế các ký tự tiếng Việt có dấu thành không dấu
    $string = str_replace($vietnamese, $non_vietnamese, $string);

    // Loại bỏ các ký tự không phải chữ và số, thay thế khoảng trắng bằng dấu gạch ngang
    $string = preg_replace('/[^A-Za-z0-9]+/', '-', strtolower(trim($string)));

    // Loại bỏ dấu gạch ngang thừa ở đầu và cuối
    return trim($string, '-');
}

function convertTitle($type)
{
    switch ($type) {
        case "post":
            return "bài viết";
        case "question":
            return "câu hỏi";
        case "document":
            return "tài liệu";
        default:
            return "";
    }
}

?>