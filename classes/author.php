<?php
class Author
{
    public $id;
    public $author;
    public $description;

    public function __construct($id, $author, $description)
    {
        $this->id = $id;
        $this->author = $author;
        $this->description = $description;
    }

    public static function add($conn, $author)
    {
        // Thêm 1 tác giả mới và trả về boolean
    }

    public static function update($conn, $author, $id)
    {
        // Sửa 1 tác giả bằng id và trả về boolean
    }

    public static function delete($conn, $id)
    {
        // Xóa tác giả trả bằng id về boolean
    }

    public static function getById($conn, $id)
    {
        // Lấy ra author bằng id và trả về 1 Object Author
    }
}
