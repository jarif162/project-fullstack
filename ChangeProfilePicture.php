<?php
require_once './components/header.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}



$userID = $_SESSION['user']->id;






?>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto my-5 border rounded shadow p-4 ">
            <h1>Change profile picture</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="profilePicture" class="form-label">Profile Picture</label>
                    <img src="<?= $_SESSION['user']->profile_picture ?? "./assets/profilePicture/pp.png" ?>" alt="Profile Picture" class="img-fluid mb-3" style="max-width: 200px;" id="profilePicturePreview">
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