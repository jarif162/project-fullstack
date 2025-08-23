<?php
require_once("./header.php");
require_once("./sidebar.php");

//include_once->if the file is not found, the script will continue to run
//require_once->if the file is not found, the script will throw an error and stop execution

if (isset($_POST['addCat'])) {
    $name = sanitize($_POST['name']);

    //validation
    if (empty($name)) {
        $errName = "Name is required";
    } else {
        $sql = "SELECT * FROM `product_categories` WHERE `name` = '$name'";
        if ($conn->query($sql)->num_rows > 0) {
            $errName = "Category already exists";
        } else {
            $sql = "INSERT INTO `product_categories` (`name`) VALUES ('$name')";
            if ($conn->query($sql) == true) {
                echo "<script>toastr.success('Category added successfully')</script>";
            }
        }
    }
}


$getCatQuery = "SELECT * FROM `product_categories`";
$getCatResult = $conn->query($getCatQuery);

if ($getCatResult->num_rows > 0) {
    $categories = $getCatResult->fetch_object();
}


?>






<div id="right-panel" class="right-panel">

    <?php

    require_once("./topbar.php");

    ?>

    <div class="breadcrumbs">
        <div class="col-12">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>categories</h1>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <?php
                    if (!isset($categories)) { ?>
                        <h2 class="mb-3">No categories</h2>

                    <?php } else { ?>
                        <!-- all categories show and fetch from database  by table use loop foreach-->
                        <h2 class="mb-3">All categories</h2>
                        <table id="catList" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Sl</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sl = 1;
                                $getCatQuery = "SELECT * FROM `product_categories` ORDER BY id DESC";
                                $getCatResult = $conn->query($getCatQuery);

                                if ($getCatResult->num_rows > 0) {
                                    while ($row = $getCatResult->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <th scope="row"><?= $sl++ ?></th>
                                            <td><?= htmlspecialchars($row['name']) ?></td>
                                            <td>
                                                <a href="product-categories.php?eid=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                                <a href="product-categories.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center'>No categories found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php } ?>


                </div>
                <div class="col-md-6">
                    <form action="" method="post">
                        <h2 class="mb-3">Add New category</h2>
                        <div class="mb-3">
                            <input type="text" placeholder="Enter your category" class="form-control <?= isset($errName) ? "is-invalid" : null ?>" name="name">
                            <div class="invalid-feedback">
                                <?= isset($errName) ? $errName : null ?>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark" name="addCat">Add category</button>

                    </form>

                    <?php
                    if (isset($_GET['eid'])) {
                        $id = (int) $_GET['eid']; // force integer
                        $getCatQuery = "SELECT * FROM `product_categories` WHERE id = $id";
                        $getCatResult = $conn->query($getCatQuery);
                        $category = $getCatResult->fetch_object();
                    }

                    ?>




                    <form action="" method="post">
                        <h2 class="mb-3">Edit category</h2>
                        <div class="mb-3">
                            <input type="text" placeholder="Enter your category" class="form-control" name="name" value="<?= isset($category) ? $category->name : null ?>">
                        </div>

                        <input type="hidden" name="id" value="<?= isset($category) ? $category->id : null ?>">
                        <button type="submit" class="btn btn-dark" name="updateCat">Update category</button>

                    </form>


                    <?php
                    // ==================== UPDATE CATEGORY ====================
                    if (isset($_POST['updateCat'])) {
                        $id = (int) $_POST['id']; // force integer for safety
                        $name = sanitize($_POST['name']);

                        // validation
                        if (empty($name)) {
                            echo "<script>toastr.error('Category name is required')</script>";
                        } else {
                            // check if category with the same name already exists (excluding current one)
                            $checkSql = "SELECT * FROM `product_categories` WHERE `name` = '$name' AND id != $id";
                            $checkResult = $conn->query($checkSql);

                            if ($checkResult->num_rows > 0) {
                                echo "<script>toastr.error('Category already exists')</script>";
                            } else {
                                $sql = "UPDATE `product_categories` SET `name` = '$name' WHERE id = $id";
                                if ($conn->query($sql) === TRUE) {
                                    echo "<script>toastr.success('Category updated successfully'); 
                      window.location.href='product-categories.php';</script>";
                                } else {
                                    echo "<script>toastr.error('Something went wrong!')</script>";
                                }
                            }
                        }
                    }



                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- .content -->
</div><!-- /#right-panel -->

<!-- Right Panel -->

<script>
    $("#catList").DataTable({
        "lengthMenu": [5, 10, 15, 20, 25],
        "pageLength": 5
    });
    //if we use data table then 
</script>


<?php
require_once("./footer.php");
?>