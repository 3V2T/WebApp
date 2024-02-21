<?php
class WishList
{
    public $id;
    public $book_id;
    public $user_id;
    public function __construct($id, $book_id, $user_id)
    {
        $this->id = $id;
        $this->book_id = $book_id;
        $this->user_id = $user_id;
    }

    public static function add($conn, $wishlist)
    {
        $query = "call yeuthich(:user_id, :book_id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':book_id', $wishlist->book_id);
        $stmt->bindParam(':user_id', $wishlist->user_id);
        return $stmt->execute();
    }

    public static function delete($conn, $id)
    {
        $query = "call xoakhoiwishlist(:id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public static function deleteByUserAndBook($conn, $user_id, $book_id)
    {
        $query = "delete from wishlist where user_id = :user_id and book_id = :book_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":book_id", $book_id);
        return $stmt->execute();
    }

    public static function getWishListByUserId($conn, $id)
    {
        $query = "call getwlbyuserid(:id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $wishlist = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($wishlist) {
            return new WishList($wishlist['id'], $wishlist['book_id'], $wishlist['user_id']);
        } else {
            return null;
        }
    }

    public static function getWishListByUserAndBook($conn, $user_id, $book_id)
    {
        $query = "select * from wishlist where user_id = :user_id and book_id = :book_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":book_id", $book_id);
        $stmt->execute();
        $wishlist = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($wishlist) {
            return new WishList($wishlist['id'], $wishlist['book_id'], $wishlist['user_id']);
        } else {
            return null;
        }
    }
}
