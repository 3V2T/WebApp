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
}
