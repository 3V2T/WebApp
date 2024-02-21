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
            <form action="controller/handleRegister.php" method="POST" class="needs-validation">
                <div class="form-group d-flex justify-content-center">
                    <h2>REGISTER</h2>
                </div>

                <div class="form-group">
                    <label for="name">Fullname</label>
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="emailHelp"
                        placeholder="Enter your full name" required>
                    <div class="invalid-feedback">Please enter your full name.</div>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp"
                        placeholder="Enter a unique username" required>
                    <div class="invalid-feedback">Please enter a unique username.</div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp"
                        placeholder="Enter a valid email address" required>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter a strong password" required minlength="8">
                    <div class="invalid-feedback">Password must be at least 8 characters.</div>
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                        placeholder="Confirm your password" required>
                    <div class="invalid-feedback">Passwords must match.</div>
                </div>

                <div class="form-group form-check" style="font-size: 14px">
                    <label class="form-check-label" for="message">Have an account?</label>
                    <a href="/WebApp/login">Click here!</a>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
        <div class=" col-4"></div>
    </div>
    <script>
    const form = document.querySelector('.needs-validation');
    const username = document.querySelector("#username");
    const password = document.querySelector("#password");
    const confirmPassword = document.querySelector("#confirmPassword");
    const email = document.querySelector("#email");
    if (localStorage.getItem("data")) {
        const data = JSON.parse(localStorage.getItem("data"));
        name.value = data.name;
        email.value = data.email;
        password.value = data.password;
        confirmPassword.value = data.confirmPassword;
    }
    form.addEventListener('submit', (event) => {
        // Basic validation using built-in constraints
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            form.classList.add('was-validated');
            return; // Stop further custom validation (if any)
        }

        // Custom validation (can be extended as needed)
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');

        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Passwords must match.');
            event.preventDefault();
            event.stopPropagation();
            return; // Stop form submission
        }

        // Allow form submission if all validations pass
        // Additional server-side validation is recommended
        form.submit();
    });
    </script>
    <?php
    if (isset($_SESSION['register_message'])) {
        echo "<script>alert('" . $_SESSION['register_message'] . "')</script>";
        session_destroy();
    } ?>

</div>