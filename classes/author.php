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
        $query = "call themauthor(:author, :description)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':author', $author->author);
        $stmt->bindParam(':description', $author->description);
        $stmt->execute();
        // Thêm 1 tác giả mới và trả về boolean
    }

    public static function update($conn, $author)
    {
        $query = "call suaauthor(:id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $author->id);
        $stmt->bindParam(':name', $author->author);
        $stmt->bindParam('description', $author->description);

        return $stmt->execute();
        // Sửa 1 tác giả bằng id và trả về boolean
    }

    public static function delete($conn, $id)
    {
        $query = "call xoaauthor(:id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
        // Xóa tác giả trả bằng id về boolean
    }

    public static function getById($conn, $id)
    {
        $query = "call getAuthorsbyid(:id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $author = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($author) {
            return new author($author['id'], $author['author'], $author['description']);
        } else {
            return null;
            // Lấy ra author bằng id và trả về 1 Object Author
        }
    }
    public static function getByName($conn, $author)
    {
        $query = "call getAuthorsbyname(:author)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':author', $author);
        $stmt->execute();

        $author = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($author) {
            return new author($author['id'], $author['author'], $author['description']);
        } else {
            return null;
            // Lấy ra author bằng id và trả về 1 Object Author
        }
    }
    public static function getAll($conn)
    {
        $query = "SELECT * FROM authors";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        $authorsList = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $author = new Author($row['id'], $row['author'], $row['description']);
            $authorsList[] = $author;
        }

        return $authorsList;
    }
}
