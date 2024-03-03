<?php session_destroy(); ?>
<style>
    .header {
        display: none;
    }

    .footer {
        display: none;
    }
</style>
<div class="bg-white mh-100 mw-100">
    <div class=" row container m-auto">
        <div class="col-4"></div>
        <div class="col-4 p-3 bg-white" style="
            box-shadow: 0px 2px 10px 2px #cccc;
            border-radius: 12px;
        ">
            <form action="controller/handleLoginAdmin.php" method="POST">
                <div class="form-group d-flex justify-content-center ">
                    <h2>
                        LOGIN FOR ADMIN
                    </h2>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp" placeholder="Enter username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
        <div class=" col-4"></div>
    </div>
</div>