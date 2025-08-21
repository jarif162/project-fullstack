<?php
require_once("./header.php");
require_once("./sidebar.php");

//include_once->if the file is not found, the script will continue to run
//require_once->if the file is not found, the script will throw an error and stop execution


?>






<div id="right-panel" class="right-panel">

    <?php

    require_once("./topbar.php");

    ?>

    <div class="breadcrumbs">
        <div class="col-12">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Add product</h1>
                </div>
            </div>
        </div>

    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="text" placeholder="product name" name=" " class="form-control">
                    </div>



                </form>
            </div>
        </div>
    </div>

    <!-- .content -->
</div><!-- /#right-panel -->

<!-- Right Panel -->

<?php
require_once("./footer.php");
?>