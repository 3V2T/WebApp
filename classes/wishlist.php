<?php
class WishList
{
    private $id;
    private $book_id;
    private $user_id;
    public function __construct($id, $book_id, $user_id)
    {
        $this->id = $id;
        $this->book_id = $book_id;
        $this->user_id = $user_id;
    }

    public function add($conn, $wishlist)
    {
        $query = "call yeuthich(:id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':book_id', $wishlist->book_id);
        $stmt->bindParam(':user_id', $wishlist->user_id);
        $stmt->execute();
        // Thêm 1 phần tử mới và trả về boolean
    }

    public function delete($conn, $id)
    {
        $query = "call xoakhoiwishlist(:id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
        // Xóa 1 phần tử bằng id và trả về boolean
    }

    public function getWishListByUserId($conn, $id)
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
            // Lấy ra tất cả phần tử trong wishlist bằng user_id
            // Trả về 1 mảng các Object WishList
            // $wishList = [
            //     Wishlist1,
            //     Wishlist2, 
            //     ...
            // ];
        }
    }
}
