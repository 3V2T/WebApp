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
        // Thêm 1 phần tử mới và trả về boolean
    }

    public function delete($conn, $id)
    {
        // Xóa 1 phần tử bằng id và trả về boolean
    }

    public function getWishListByUserId($conn, $id)
    {
        // Lấy ra tất cả phần tử trong wishlist bằng user_id
        // Trả về 1 mảng các Object WishList
        // $wishList = [
        //     Wishlist1,
        //     Wishlist2, 
        //     ...
        // ];
    }
}
