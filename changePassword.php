<?php
require_once './components/header.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}



$userID = $_SESSION['user']->id;

if (isset($_POST['changePassword'])) {
    $oldPassword = sanitize($_POST['oldPassword']);
    $newPassword = sanitize($_POST['newPassword']);
    $confirmPassword = sanitize($_POST['confirmPassword']);

    $oldPassword = $conn->real_escape_string($oldPassword);
    $newPassword = $conn->real_escape_string($newPassword);
    $confirmPassword = $conn->real_escape_string($confirmPassword);

    if (empty($oldPassword)) {
        $errorOldPassword = "Old Password is required";
    } else {
        $sql = "SELECT * FROM users WHERE id = $userID AND password = '$oldPassword'";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            $errorOldPassword = "Old Password is incorrect";
        }
    }

    if (empty($newPassword)) {
        $errorNewPassword = "New Password is required";
    } elseif (strlen($newPassword) < 6) {
        $errorNewPassword = "Password must be at least 6 characters long";
    } else {
        $crrNewPassword = $conn->real_escape_string($newPassword);
    }

    if (empty($confirmPassword)) {
        $errorConfirmPassword = "Confirm Password is required";
    } elseif ($newPassword !== $confirmPassword) {
        $errorConfirmPassword = "Passwords do not match";
    } else {
        $crrConfirmPassword = $conn->real_escape_string($confirmPassword);
    }

    if (isset($crrNewPassword) && isset($crrConfirmPassword) && !isset($errorOldPassword) && !isset($errorNewPassword) && !isset($errorConfirmPassword)) {
        $userinfo = $conn->query("SELECT * FROM users WHERE id = $userID")->fetch_object();
        if (password_verify($oldPassword, $userinfo->password)) {
            $hashedNewPassword = password_hash($crrNewPassword, PASSWORD_DEFAULT);
            $updateSql = "UPDATE users SET password = '$hashedNewPassword' WHERE id = $userID";
            if ($conn->query($updateSql)) {
                echo "<script>alert('Password changed successfully');</script>";
            } else {
                echo "<script>alert('Error updating password');</script>";
            }
        } else {
            $errorOldPassword = "Old Password is incorrect";
        }
    }
}




?>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto my-5 border rounded shadow p-4 ">
            <h1>Change password</h1>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="oldPassword" class="form-label">Current Password</label>
                    <input type="password" class="form-control <?= isset($errorOldPassword) ? 'is-invalid' : null ?> " name="oldPassword" value="<?= $oldPassword ?? null ?>">
                </div>
                <div class="invalid-feedback">
                    <?php
                    if (isset($errorOldPassword)) {
                        echo $errorOldPassword;
                    } else {
                        echo null;
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="newPassword" class="form-label">New Password</label>
                    <input type="password" class="form-control <?= isset($errorNewPassword) ? 'is-invalid' : null ?> " name="newPassword" value="<?= $newPassword ?? null ?>">
                </div>
                <div class="invalid-feedback">
                    <?php
                    if (isset($errorNewPassword)) {
                        echo $errorNewPassword;
                    } else {
                        echo null;
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control <?= isset($errorConfirmPassword) ? 'is-invalid' : null ?> " name="confirmPassword" value="<?= $confirmPassword ?? null ?>">
                </div>
                <div class="invalid-feedback">
                    <?php
                    if (isset($errorConfirmPassword)) {
                        echo $errorConfirmPassword;
                    } else {
                        echo null;
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" name="changePassword">Change Password</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- <script>
    //ckbox
    // CKBOX.mount(document.querySelectorAll('#editor'), {
    //     toolbar: [
    //         ['heading', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
    //         ['undo', 'redo']
    //     ]
    // });
</script> -->








<?php
require_once './components/footer.php';

?>