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
        $this->author_id = $author_id;
        $this->category_id = $category_id;
        $this->description = $description;
        $this->published = $published;
        $this->cover_path = $cover_path;
        $this->file_path = $file_path;
    }

    private function validate()
    {
        return $this->title && $this->author_id && $this->category_id && $this->description && $this->published && $this->cover_path && $this->file_path;
    }

    public static function add($conn, $book)
    {
        //Thêm sách mới trả về boolean
        if ($book->validate()) {
            $sql = "INSERT INTO books (title, author_id, category_id, description, published, cover_path, file_path)
                VALUES (:title, :author_id, :category_id, :description, :published, :cover_path, :file_path)";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':title', $book->title);
            $stmt->bindParam(':author_id', $book->author_id);
            $stmt->bindParam(':category_id', $book->category_id);
            $stmt->bindParam(':description', $book->description);
            $stmt->bindParam(':published', $book->published);
            $stmt->bindParam(':cover_path', $book->cover_path);
            $stmt->bindParam(':file_path', $book->file_path);
            return $stmt->execute();
        } else {
            return false;
        }
    }

    public static function update($conn, $book, $id)
    {
        //Sửa sách bằng id trả về boolean
        if ($book->validate()) {
            try {
                $sql = "UPDATE books
                SET title = :title, 
                    author_id = :author_id, 
                    category_id = :category_id, 
                    description = :description, 
                    published = :published, 
                    cover_path = :cover_path, 
                    file_path = :file_path
                WHERE id = :id";

                $stmt = $conn->prepare($sql);

                $stmt->bindParam(':title', $book->title);
                $stmt->bindParam(':author_id', $book->author_id);
                $stmt->bindParam(':category_id', $book->category_id);
                $stmt->bindParam(':description', $book->description);
                $stmt->bindParam(':published', $book->published);
                $stmt->bindParam(':cover_path', $book->cover_path);
                $stmt->bindParam(':file_path', $book->file_path);
                $stmt->bindParam(':id', $id);
                return $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        } else {
            return false;
        }
    }

    public static function delete($conn, $id)
    {
        //Xóa sách bằng id trả về boolean
        try {
            $sql = "DELETE FROM books WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
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
        try {
            $sql = "SELECT * FROM books";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $booksList = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $booksList[] = new Book(
                    $row['id'],
                    $row['title'],
                    $row['author_id'],
                    $row['category_id'],
                    $row['description'],
                    $row['published'],
                    $row['cover_path'],
                    $row['file_path']
                );
            }
            return $booksList;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getById($conn, $id)
    {
        //Lấy ra 1 quyển sách bằng id
        //Trả về 1 Object Book
        try {
            $sql = "SELECT * FROM books WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new Book(
                    $row['id'],
                    $row['title'],
                    $row['author_id'],
                    $row['category_id'],
                    $row['description'],
                    $row['published'],
                    $row['cover_path'],
                    $row['file_path']
                );
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getByCategory($conn, $category_name)
    {
        //Lấy ra các quyển sách bằng tên của phân loại (String)
        //Trả về mảng các Object Book
        try {
            $sql = "SELECT * FROM books INNER JOIN categories ON books.category_id = categories.id WHERE categories.category = :category_name";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':category_name', $category_name);
            $stmt->execute();

            $booksList = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $booksList[] = new Book(
                    $row['id'],
                    $row['title'],
                    $row['author_id'],
                    $row['category_id'],
                    $row['description'],
                    $row['published'],
                    $row['cover_path'],
                    $row['file_path']
                );
            }
            return $booksList;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getByKeyWord($conn, $key_word)
    {
        //Lấy ra các quyển sách có từ khóa trong tên
        //Trả về mảng các Object Book
        try {
            $sql = "SELECT * FROM books WHERE title LIKE :key_word";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':key_word', '%' . $key_word . '%');
            $stmt->execute();

            $booksList = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $booksList[] = new Book(
                    $row['id'],
                    $row['title'],
                    $row['author_id'],
                    $row['category_id'],
                    $row['description'],
                    $row['published'],
                    $row['cover_path'],
                    $row['file_path']
                );
            }

            return $booksList;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
