<?php
require_once './components/header.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$genderList = ["Male", "Female", "Others"];

$userID = $_SESSION['user']->id;

$userInfo = $conn->query("SELECT * FROM users WHERE id = $userID")->fetch_object();


if (isset($_POST['updateProfile'])) {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $gender = isset($_POST['gender']) ? sanitize($_POST['gender']) : null;
    $address = sanitize($_POST['address']);


    if (empty($name)) {
        $errName = "Name is required";
    } elseif (!preg_match("/^[a-zA-Z. ]*$/", $name)) {
        $errName = "Only letters and white space allowed";
    } else {
        $crrName = $conn->real_escape_string($name);
    }

    if (empty($email)) {
        $errEmail = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errEmail = "Invalid email format";
    } else {
        $crrEmail = $conn->real_escape_string($email);
    }

    if (empty($gender)) {
        $errGender = "Gender is required";
    } elseif (!in_array($gender, $genderList)) {
        $errGender = "Invalid gender";
    } else {
        $crrGender = $conn->real_escape_string($gender);
    }

    if (empty($address)) {
        $errAddress = "Address is required";
    } else {
        $crrAddress = $conn->real_escape_string($address);
    }
}


?>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto my-5 border rounded shadow p-4 ">
            <h1>My Profile</h1>
            <form action="" method="post">
                <!-- name section -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text " class="form-control <?= isset($errName) ? "is-invalid" : null ?> " name="name" value="<?= isset($userInfo->name) ? $userInfo->name : null ?>">

                    <div class="invalid-feedback">
                        <?php
                        if (isset($errName)) {
                            echo $errName;
                        } else {
                            echo null;
                        }
                        ?>

                    </div>
                </div>
                <!-- email section -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control <?= isset($errEmail) ? "is-invalid" : null ?>" name="email" value="<?= isset($userInfo->email) ? $userInfo->email : null ?>">

                    <div class="invalid-feedback">
                        <?php
                        if (isset($errEmail)) {
                            echo $errEmail;
                        } else {
                            echo null;
                        }
                        ?>
                    </div>
                </div>
                <!-- Gender section -->
                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <div class=" position-relative py-2 px-2">
                        <input type="text" class="form-control position-absolute top-0 start-0 z-n1 bg-white <?= isset($errGender) ? "is-invalid" : null ?>" disabled>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="male" value="Male" name="gender" <?= $userInfo->gender == "Male" ? "checked" : null  ?>>
                            <label class="form-label" for="male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="female" value="Female" name="gender" <?= $userInfo->gender == "Female" ? "checked" : null  ?>>
                            <label class="form-label" for="female">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="others" value="Others" name="gender" <?= $userInfo->gender == "Others" ? "checked" : null  ?>>
                            <label class="form-label" for="others">Others</label>
                        </div>

                        <div class="invalid-feedback">
                            <?php
                            if (isset($errGender)) {
                                echo $errGender;
                            } else {
                                echo null;
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Address section -->
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <!-- <input type="text" class="form-control" name="address"> -->
                    <textarea class="form-control<?= isset($errAddress) ? "is-invalid" : null ?> " name="address" rows="3" style="resize: none;" id="editor">
                        <?= isset($userInfo->address) ? $userInfo->address : null ?>
                    </textarea>
                    <div class="invalid-feedback">
                        <?= isset($errAddress) ? $errAddress : null ?>
                    </div>

                    <!-- Submit button -->
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="updateProfile">Update Profile</button>
                    </div>

            </form>
        </div>
    </div>
</div>

<script>
    //ckbox
    // CKBOX.mount(document.querySelectorAll('#editor'), {
    //     toolbar: [
    //         ['heading', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
    //         ['undo', 'redo']
    //     ]
    // });
</script>






<?php
require_once './components/footer.php';

?>