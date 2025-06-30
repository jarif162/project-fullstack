<?php
require_once './components/header.php';
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['signup123'])) {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    $confirmPassword = sanitize($_POST['confirmPassword']);

    if (empty($name)) {
        $errName = "Name is required";
    } elseif (!preg_match("/^[a-zA-Z. ]*$/", $name)) {
        $errName = "Only letters and white space allowed";
    } else {
        $crrName = $name;
    }

    if (empty($email)) {
        $errEmail = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errEmail = "Invalid email format";
    } else {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $checkEmail = $conn->query($sql);
        if ($checkEmail->num_rows > 0) {
            $errEmail = "Email already exists";
        } else {
            $crrEmail = $email;
        }
        $crrEmail = $email;
    }

    if (empty($password)) {
        $errPassword = "Password is required";
    }
    // elseif (!preg_match("/ ^[A-Za-z0-9!@#$^&+=]{8,}$/", $password)) 
    elseif (strlen($password) < 6) {
        $errPassword = "Password must be at least 6 characters long";
    } else {
        $crrPassword = password_hash($password, PASSWORD_DEFAULT);
    }

    if (empty($confirmPassword)) {
        $errConfirmPassword = "Confirm Password is required";
    } elseif ($confirmPassword !== $password) {
        $errConfirmPassword = "Passwords do not match";
    } else {
        $crrConfirmPassword = $confirmPassword;
    }


    if (isset($crrName) && isset($crrEmail) && isset($crrPassword) && isset($crrConfirmPassword)) {
        $crrPassword = password_hash($crrPassword, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (`name`, `email`, `password`) VALUES ('$crrName', '$crrEmail', '$crrPassword')";
        if (mysqli_query($conn, $sql)) {
            echo "
            <script>
            toastr.success('Sign up successful');
            setTimeout(() => {
                window.location.href = 'sign-in.php';
            }, 2000);
            </script>";

            // $_SESSION['success'] = "Registration successful. Please sign in.";
            // header("Location: sign-in.php");
            exit();
        } else {
            // $_SESSION['error'] = "Error: " . mysqli_error($conn);
            echo "<script>toastr.error('Sign up failed')</script>";
        }
    }
}


?>


<div class="container">
    <div class="row">
        <div class="col-md-5 mx-auto my-5 border rounded shadow py-3 ">
            <h2>sign up</h2>
            <form action="" method="post">
                <div class="mb-3">
                    <div>
                        <label for="name" class="form-label ">Full Name</label>
                        <input type="text" class="form-control <?= isset($errName) ? "is-invalid" : null ?> ) ?>" id="name" name="name" value="<?= $name ?? null ?>">
                        <div class="invalid-feedback"><?= $errName ?? null ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="text" class="form-control <?= isset($errEmail) ? "is-invalid" : null ?> " id="email" name="email" value="<?= $email ?? null ?>">
                        <div class="invalid-feedback"><?= $errEmail ?? null ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control <?= isset($errPassword) ? "is-invalid" : null  ?>" id="password" name="password" value="<?= $password ?? null ?>">
                        <div class="invalid-feedback"><?= $errPassword ?? null ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control <?= isset($errConfirmPassword) ? "is-invalid" : null ?>" id="confirmPassword" name="confirmPassword" value="<?= $confirmPassword ?? null ?>">
                        <div class="invalid-feedback"><?= $errConfirmPassword ?? null ?></div>
                    </div>
                    <div class="mb-3">
                        <!-- showpassword -->
                        <input type="checkbox" id="showPass" class="form-check-input">
                        <label for="showPass">Show Password</label>
                    </div>
                    <button type="submit" class="btn btn-primary " name="signup123">sign up</button>
                    <p class="mt-3">Already have an account? <a href="sign-in.php">sign in</a></p>
                </div>
        </div>
    </div>

    <script>
        const showPass = document.getElementById('showPass');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');
        showPass.addEventListener('click', function() {
            if (this.checked) {
                password.setAttribute('type', 'text');
                confirmPassword.setAttribute('type', 'text');
            } else {
                password.setAttribute('type', 'password');
                confirmPassword.setAttribute('type', 'password');
            }
        });

        //here this and showPass are used to toggle the password visibility and this use instead of showPass
    </script>







    <?php
    require_once './components/footer.php';

    ?>