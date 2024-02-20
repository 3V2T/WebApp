<?php
class Category
{
    public $id;
    public $category;
    public $name;

    public function __construct($id, $category, $name)
    {
        $this->id = $id;
        $this->category = $category;
        $this->name = $name;
    }

    public static function getAll($conn)
    {
        $query = "SELECT * FROM categories";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        $categoriesList = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories = new Category($row['id'], $row['category'], $row['name']);
            $categoriesList[] = $categories;
        }

        return $categoriesList;
    }

    public static function getById($conn, $id)
    {
        $query = "call getCategoriesbyid(:id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($category) {
            return new Category($category['id'], $category['category'], $category['name']);
        } else {
            return null;
            // Lấy ra author bằng id và trả về 1 Object Author
        }
    }
}
