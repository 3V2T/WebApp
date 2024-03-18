<?php

?><nav class="header navbar navbar-expand-lg navbar-light bg-light position-fixed"
    style="box-shadow: 1px 1px 10px 0px black; top: 0; left: 0; right:0; z-index: 5;">
    <div class="container">
        <a class="navbar-brand" href="<?php echo BASE_URL . "/home" ?>">Trang chủ</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Category
                    </a>
                    <div class="dropdown-menu"
                        style="height: 300px; overflow-y:scroll;box-shadow: 2px 2px 5px 2px #cccc;"
                        aria-labelledby="navbarDropdown">
                        <?php
                        $list = Category::getAll($connection);
                        $category_all = new Category(1, "tat-ca", "Tất cả");
                        array_push($list, $category_all);
                        foreach ($list as $item) {
                            echo "<a class='dropdown-item' href='". BASE_URL ."/pages/book.php?type={$item->category}'>{$item->name}</a>";
                        }
                        ?>
                    </div>
                </li>
                <?php
                if (isset($_SESSION["is_admin"])) {
                    if ($_SESSION["is_admin"]) {
                        echo '<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Action
                            </a>
                            <div class="dropdown-menu" style="box-shadow: 2px 2px 5px 2px #cccc;"
                                aria-labelledby="navbarDropdown">
                                <a class= "dropdown-item" href="'. BASE_URL .'/user">Users</a>
                                <a class= "dropdown-item" href="'. BASE_URL .'/category">Category</a>
                                <a class= "dropdown-item" href="'. BASE_URL .'/author">Author</a>
                                <a class= "dropdown-item" href="'. BASE_URL .'/upload">Upload</a>
                            </div>
                        </li>';
                    }
                }
                ?>
            </ul>
            <div class="d-flex" style="gap: 16px;">
                <form class="form-inline my-2 my-lg-0" method="get" action="<?php echo BASE_URL ?>/pages/search.php">
                    <input class=" form-control mr-sm-2" type="search" name="keyword"
                        style="box-shadow: 2px 2px 5px 2px #cccc;" placeholder="Nhập tên sách" aria-label="Tìm kiếm">
                    <button class="btn btn-outline-success my-2 my-sm-0" style="box-shadow: 2px 2px 5px 2px #cccc;"
                        type="submit">Tìm kiếm</button>
                </form>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle btn btn-btn-outline-light " href="" id="navbarDropdown"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?php
                            echo (isset($_SESSION['is_admin'])) ? "ADMIN" : "ME"
                            ?>
                        </a>
                        <div class="dropdown-menu" style="box-shadow: 2px 2px 5px 2px #cccc;"
                            aria-labelledby="navbarDropdown">
                            <?php echo (isset($_SESSION['is_admin'])) ? '<a class="dropdown-item" href="'. BASE_URL.'/pages/admin.php">Đổi mật khẩu</a><a class="dropdown-item" href="'.BASE_URL.'/controller/handleLogoutAdmin.php">Đăng
                            xuất</a>' : '<a class="dropdown-item" href="'. BASE_URL.'/pages/me.php">Thông tin cá
                                nhân</a>
                            <a class="dropdown-item" href="'. BASE_URL.'/wishlist">Sách yêu thích</a><a
                                class="dropdown-item" href="'.BASE_URL.'/controller/handleLogout.php">Đăng
                                xuất</a>' ?>

                        </div>
                    </li>
                </ul>
            </div>
        </div>
</nav>
<div style="margin-top: 60px;"></div>