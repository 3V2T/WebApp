<style>
    .header {
        display: none;
    }

    .footer {
        display: none;
    }
</style>
<div class="bg-white d-flex" style="top: 0; left: 0; bottom: 0; right: 0; z-index: 10;">
    <div class="row container m-auto">
        <div class="col-4"></div>
        <div class="col-4 p-3 bg-white" style="
            box-shadow: 0px 2px 10px 2px #cccc;
            border-radius: 12px;
        ">
            <form action="controller/handleLogin.php" method="POST">
                <div class="form-group d-flex justify-content-center ">
                    <h2>
                        REGISTER
                    </h2>
                </div>
                <div class="form-group">
                    <label for="username">Fullname</label>
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="emailHelp" placeholder="Enter username">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp" placeholder="Enter username">
                </div>
                <div class="form-group">
                    <label for="username">Email</label>
                    <input type="text" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <label for="password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Enter password">
                </div>
                <div class="form-group form-check" style="font-size: 14px">
                    <label class="form-check-label" for="message">Have no account?</label>
                    <a href="">Click here!</a>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class=" col-4"></div>
    </div>
</div>