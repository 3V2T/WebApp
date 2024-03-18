<div class="container min-vh-100 mt-4">
    <h1 class="pt-4">Thể loại </h1>
    <div class="container">
        <div class="row gap-3">
            <div class="col-12">
                <table class="table mt-5">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $categoryList = Category::getAll($connection);
                        $i = 0;
                        foreach ($categoryList as $category) {
                            echo '<tr>
                                    <th scope="row">' . ++$i . '</th>
                                    <td>' . $category->id . '</td>
                                    <td><input class="input-category p-2 authorId-' . $category->id . '" value="' . $category->name . '"></td>
                                    <td>
                                    <div class="d-flex justify-content-around">
                                    <a class="px-2 justify-content-between btn undoBtn btn-primary text-white">Undo</a>
                                    <button data-toggle="modal" data-target="#modalDelete' . $category->id . '" class="px-2  btn btn-danger text-white">Delete</button>
                                    <div class="modal fade" id="modalDelete' . $category->id . '" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel' . $category->id . '" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalDeleteLabel' . $category->id . '">Notice</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Deleting this category will delete it' . "'"  . 's books, do you want to continue this action?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                <a type="button" class="btn btn-danger text-white" href="'.BASE_URL.'/controller/handleDeleteCategory.php?id=' . $category->id . '">Delete</a>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <form action="'.BASE_URL.'/controller/handleUpdateCategory.php?id=' . $category->id . '" method="post" class="editform categoryId-' . $category->id . '">
                                        <input class="d-none" name="category_name" required></input>
                                        <button class="px-2  btn btn-success text-white">Save</button>
                                        </form>
                                    </div>
                                    </td>
                                    </tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <form class="d-flex p-5" method="post" action="<?php echo BASE_URL ?>/controller/handleAddCategory.php"
                    style="gap: 8px">
                    <input class="form-control" name="category_name" placeholder=" Enter category" required>
                    <button class="btn btn-danger ">
                        Clear
                    </button>
                    <button class="btn btn-success">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
const undoBtn = document.querySelectorAll(".undoBtn");
undoBtn.forEach((btn, index) => {
    btn.onclick = (e) => {
        location.href = "<?php echo BASE_URL ?>/category";
    }
})
const inputCategory = document.querySelectorAll(".input-category");
const inputEdit = document.querySelectorAll(".editform input");
inputCategory.forEach((element, index) => {
    inputEdit[index].value = element.value;
    element.onchange = (e) => {
        inputEdit[index].value = e.target.value;
        console.log(e.target.value);
    }
})
</script>