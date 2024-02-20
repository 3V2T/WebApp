<nav class="header navbar navbar-expand-lg navbar-light bg-light position-fixed" style="box-shadow: 1px 1px 10px 0px black; top: 0; left: 0; right:0; z-index: 5;">
    <div class="container">
        <a class="navbar-brand" href="<?php echo baseURL("home") ?>">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Categories
                    </a>
                    <div class="dropdown-menu" style="box-shadow: 2px 2px 5px 2px #cccc;" aria-labelledby="navbarDropdown">
                        <?php
                        $list = [
                            (object) [
                                "name" => "Tất cả",
                                "slug" => "all",
                            ],
                            (object) [
                                "name" => "Thiếu nhi",
                                "slug" => "thieu-nhi",
                            ],
                            (object) [
                                "name" => "Khoa học",
                                "slug" => "khoa-hoc",
                            ],
                            (object) [
                                "name" => "Tâm lý",
                                "slug" => "tam-ly",
                            ],
                            (object) [
                                "name" => "Lịch sử",
                                "slug" => "lich-su",
                            ],

                            (object) [
                                "name" => "Văn học",
                                "slug" => "van-hoc",
                            ],
                        ];
                        foreach ($list as $item) {
                            echo "<a class='dropdown-item' href='/WebApp/pages/book.php?type={$item->slug}'>{$item->name}</a>";
                        }
                        ?>
                    </div>
                </li>
            </ul>
            <div class="d-flex" style="gap: 16px;">
                <form class="form-inline my-2 my-lg-0" method="get" action="/WebApp/pages/search.php">
                    <input class=" form-control mr-sm-2" type="search" name="keyword" style="box-shadow: 2px 2px 5px 2px #cccc;" placeholder="Nhập tên sách" aria-label="Tìm kiếm">
                    <button class="btn btn-outline-success my-2 my-sm-0" style="box-shadow: 2px 2px 5px 2px #cccc;" type="submit">Tìm kiếm</button>
                </form>
                <div class="dropdown d-flex">
                    <a class="btn bg-white dropdown-toggle m-auto " style="box-shadow: 2px 2px 5px 2px #cccc;" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="user-name">Me</span>
                        <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="#">Thông tin cá nhân</a>
                        <a class="dropdown-item" href="#">Yêu thích</a>
                        <a class="dropdown-item" href="#">Lịch sử đọc</a>
                        <a class="dropdown-item" href="controller/handleLogout.php">Đăng
                            xuất</a>
                    </div>
                </div>

            </div>
        </div>
</nav>
<div style="margin-top: 60px;"></div>