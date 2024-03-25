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

    public static function updateInfo($conn, $book, $id)
    {
        if ($book->validate()) {
            try {
                $sql = "UPDATE books
                SET title = :title, 
                    author_id = :author_id, 
                    category_id = :category_id, 
                    description = :description, 
                    published = :published
                WHERE id = :id";

                $stmt = $conn->prepare($sql);

                $stmt->bindParam(':title', $book->title);
                $stmt->bindParam(':author_id', $book->author_id);
                $stmt->bindParam(':category_id', $book->category_id);
                $stmt->bindParam(':description', $book->description);
                $stmt->bindParam(':published', $book->published);
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

    public static function update($conn, $book, $id)
    {
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

    public static function getLimit($conn)
    {
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


    public static function getByTitle($conn, $title)
    {
        try {
            $sql = "SELECT * FROM books WHERE title = :title";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':title', $title);
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

    public static function getByCategory($conn, $category)
    {
        try {
            $sql = "SELECT books.id, books.title, books.author_id, books.category_id, books.description, books.published, books.cover_path, books.file_path, categories.category
            FROM books
            INNER JOIN categories ON books.category_id = categories.id
            WHERE categories.category = :category";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':category', $category);
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

    public static function getByAuthor($conn, $author_id)
    {
        try {
            $sql = "CALL getBooksbyauthorid(:author_id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':author_id', $author_id);
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
        try {
            $sql = "CALL timsach(:keyword)";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':keyword', $key_word);
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

    public static function getPagingBooks($conn, $limit, $offset)
    {
        try {
            $sql = "select * from books order by title asc
                limit :limit
                offset :offset";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            //$stmt->setFetchMode(PDO::FETCH_CLASS, 'Book');
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
