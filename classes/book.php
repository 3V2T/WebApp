<?php
class Book
{
    public $id;
    public $title;
    public $author_id;
    public $category_id;
    public $description;
    public $published;
    public $cover_path;
    public $file_path;

    public function __construct($id, $title, $author_id, $category_id, $description, $published, $cover_path, $file_path)
    {
        $this->id = $id;
        $this->title = $title;
        $this->category_id = $category_id;
        $this->description = $description;
        $this->published = $published;
        $this->cover_path = $cover_path;
        $this->file_path = $file_path;
    }

    public static function add($conn, $book)
    {
        //Thêm sách mới trả về boolean
    }

    public static function update($conn, $book, $id)
    {
        //Sửa sách bằng id trả về boolean
    }

    public static function delete($conn, $id)
    {
        //Xóa sách bằng id trả về boolean
    }

    public static function getAll($conn)
    {
        //Lấy thông tin tất cả các cuốn sách
        //Trả về 1 mảng chưa các Object Book
        // $booksList = [
        //     book1
        //     book2, 
        //     ...
        // ];
    }

    public static function getById($conn, $id)
    {
        //Lấy ra 1 quyển sách bằng id
        //Trả về 1 Object Book
    }

    public static function getByCategory($conn, $category_name)
    {
        //Lấy ra các quyển sách bằng tên của phân loại (String)
        //Trả về mảng các Object Book
    }

    public static function getByKeyWord($conn, $key_word)
    {
        //Lấy ra các quyển sách có từ khóa trong tên
        //Trả về mảng cách Object Book
    }
}
