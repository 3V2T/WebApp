<?php
session_start();
include_once "../utils/routerConfig.php";
include "../classes/database.php";
include "../classes/category.php";
include "../config.php";
$conn = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$connection = $conn->getConn();

// function convertToSlug($str)
// {
//     $str = strtolower($str); //chuyển chữ hoa thành chữ thường
//     $unicode = array(
//         'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
//         'd' => 'đ',
//         'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
//         'i' => 'í|ì|ỉ|ĩ|ị',
//         'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
//         'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
//         'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
//         'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
//         'D' => 'Đ',
//         'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
//         'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
//         'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
//         'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
//         'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
//     );
//     foreach ($unicode as $nonUnicode => $uni) {
//         $str = preg_replace("/($uni)/i", $nonUnicode, $str);
//     }
//     $str = str_replace(' ', '-', $str);
//     return $str;
// }
function create_slug($string)
{
    $search = array(
        '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
        '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
        '#(ì|í|ị|ỉ|ĩ)#',
        '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
        '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
        '#(ỳ|ý|ỵ|ỷ|ỹ)#',
        '#(đ)#',
        '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
        '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
        '#(Ì|Í|Ị|Ỉ|Ĩ)#',
        '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
        '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
        '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
        '#(Đ)#',
        "/[^a-zA-Z0-9\-\_]/",
    );
    $replace = array(
        'a',
        'e',
        'i',
        'o',
        'u',
        'y',
        'd',
        'A',
        'E',
        'I',
        'O',
        'U',
        'Y',
        'D',
        '-',
    );
    $string = preg_replace($search, $replace, $string);
    $string = preg_replace('/(-)+/', '-', $string);
    $string = strtolower($string);
    return $string;
}
if (isset ($_POST['category_name'])) {
    $category_name = $_POST['category_name'];
    try {
        $category = new Category(1, /*convertToSlug*/create_slug($category_name), $category_name);
        Category::add($connection, $category);
        echo '<script>alert("Thêm thể loại thành công!");
            location.href = "' . BASE_URL . '/category";
        </script>';
    } catch (\Throwable $e) {
        echo '<script>alert("Đã xảy ra lỗi vui lòng thử lại!");
            location.href = "' . BASE_URL . '/category";
        </script>';
    }
}