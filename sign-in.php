<?php
require_once './components/header.php';
//setCookie trycount=0
if (isset($_SESSION['user']) //check if user is already logged in
) {
    header("Location: index.php");
    exit();
}


if (!isset($_COOKIE['trycount'])) {
    setcookie('trycount', 0, time() + 60 * 15, "/"); // Set trycount to 0 for 15 minutes
}



if (isset($_POST['signin123'])) {
    // echo "<script>toastr.error('Please fill in all fields');</script>";
    if ($_COOKIE['trycount'] >= 3) {
        echo "<script>toastr.error('Too many attempts. Please try again later.');</script>";
    } else {
        $email = sanitize($_POST['email']);
        $password = sanitize($_POST['password']);
        if (empty($email)) {
            $errEmail = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errEmail = "Invalid email format";
        } else {
            $crrEmail = $email;
        }

        if (empty($password)) {
            $errPassword = "Password is required";
        } else {
            $crrPassword = $password;
        }

        if (isset($crrEmail) && isset($crrPassword)) {
            $sql = "SELECT * FROM `users` WHERE `email` = '$crrEmail'";
            // $result = mysqli_query($conn, $sql);
            // if (mysqli_num_rows($result) > 0) {
            //     $user = mysqli_fetch_assoc($result);
            //     if (password_verify($crrPassword, $user['password'])) {
            //         $_SESSION['user'] = $user;
            //         echo "
            //         <script>
            //         toastr.success('Sign in successful');
            //         setTimeout(() => {
            //             window.location.href = 'index.php';
            //         }, 2000);
            //         </script>";
            //     } else {
            //         echo "<script>toastr.error('Invalid password');</script>";
            //     }
            // } else {
            //     echo "<script>toastr.error('No user found with this email');</script>";
            // }

            $checkEmail = $conn->query($sql);
            if ($checkEmail->num_rows != 1) {
                //$checkEmail->num_rows ->explain how it works in php


                echo "<script>toastr.error('No user found with this email');</script>";
                setcookie('trycount', $_COOKIE['trycount'] + 1, time() + 60 * 15, "/"); // Increment trycount
            } else {
                $row = $checkEmail->fetch_object();
                if (!password_verify($crrPassword, $row->password)) {
                    echo "<script>toastr.error('Invalid password');</script>";
                    setcookie('trycount', $_COOKIE['trycount'] + 1, time() + 60 * 15, "/"); // Increment trycount
                } else {
                    $_SESSION['user'] = $row;
                    echo "
                <script>
                toastr.success('Sign in successful');
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 2000);
                </script>";
                }
            }
        }
    }
}


?>


<div class="container">
    <div class="row">
        <div class="col-md-5 mx-auto my-5 border rounded shadow py-3 ">
            <h2>sign in</h2>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <!-- showpassword -->
                    <input type="checkbox" id="showPass" class="form-check-input" name="remember">
                    <label for="remember" class="form-label" class="form-check-label">Show Password</label>
                </div>
                <button type="submit" class="btn btn-primary" name="signin123">sign in</button>
                <p class="mt-3">don't have an account? <a href="sign-up.php">sign up</a></p>
        </div>
    </div>
</div>

<script>
    document.getElementById('showPass').addEventListener('change', function() {
        const passwordField = document.getElementById('password');
        if (this.checked) {
            passwordField.type = 'text';
        } else {
            passwordField.type = 'password';
        }
    });
</script>




<?php
require_once './components/footer.php';

?>