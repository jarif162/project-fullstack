<?php
require_once './components/header.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}



$userID = $_SESSION['user']->id;


if (isset($_POST['updateProfilePicture'])) {
    $profilePicture = $_FILES['profilePicture'] ?? null;

    if (empty($profilePicture['name'])) {
        $errProfilePicture = "Please select a profile picture.";
    } elseif ($profilePicture['size'] > 2000000) {
        $errProfilePicture = "Profile picture size should be less than 2 MB.";
    } elseif (!in_array($profilePicture['type'], ['image/jpeg', 'image/png', 'image/gif'])) {
        $errProfilePicture = "Invalid file type. Only JPEG, PNG, and GIF are allowed.";
    } else {
        $imageExt = pathinfo($profilePicture['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid() . date("hmsmdy") . rand(1000, 9999) . '.' . $imageExt;
        $targetDir = './assets/profilePicture/';
        $targetFile = $targetDir . "/" . $newFileName;
        $tempImage = $_FILES['profilePicture']['tmp_name'];
        if (move_uploaded_file($tempImage, $targetFile)) {
            // Delete the old profile picture if it exists
            unlink($targetDir . $_SESSION['user']->picture);
            $query = "UPDATE users SET picture = '$newFileName ' WHERE id = '$userID'";
            $result = mysqli_query($conn, $query);
            if ($result) {
                $_SESSION['user']->picture = $newFileName;
                echo "<script>toastr.success('Profile picture updated successfully',setTimeout(() => location.href = './ChangeProfilePicture.php', 2000));</script>";
            } else {
                $errProfilePicture = "Failed to update profile picture in the database.";
            }
        } else {
            $errProfilePicture = "Failed to upload the profile picture. Please try again.";
        }
    }
}






?>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto my-5 border rounded shadow p-4 ">
            <h1>Change profile picture</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="profilePicture" class="form-label">Profile Picture</label>
                    <img src="<?= isset($_SESSION['user']->picture) ? "./assets/profilePicture/" . $_SESSION['user']->picture : "./assets/profilePicture/default.jpg" ?>" alt="Profile Picture" class="img-fluid mb-3" style="max-width: 200px;" id="profilePicturePreview">
                    <p class="text-muted">Upload a new profile picture (JPEG, PNG, GIF)</p>
                    <input type="file" name="profilePicture" id="profilePicture" name="profilePicture" accept="image/jpeg, image/png, image/gif"
                        class="form-control <?= isset($errProfilePicture) ? "is-invalid" : null ?>"
                        id="profilePicture">

                </div>
                <div class="invalid-feedback">
                    <?php
                    if (isset($errProfilePicture)) {
                        echo $errProfilePicture;
                    } else {
                        echo null;
                    }
                    ?>

                </div>
                <button type="submit" class="btn btn-dark" name="updateProfilePicture">update</button>

            </form>


        </div>
    </div>
</div>

<script>
    $("#profilePicture").on("change", function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#profilePicturePreview").attr("src", e.target.result);
            }
            reader.readAsDataURL(file);
        } else {
            $("#profilePicturePreview").attr("src", "./assets/profilePicture/pp.png");
        }
    });
</script>








<?php
require_once './components/footer.php';

?>