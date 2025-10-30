<?php
require_once './components/header.php';


?>

<div class="container">
    <!-- hero section -->
    <div class="row">
        <div class=" d-flex align-items-center justify-content-center flex-column flex-md-row">
            <div>
                <h1 class="text-primary">
                    Welcome to our online store
                </h1>
                <p class="lead">Your one-stop shop for all</p>
                <!--social media bar -->
                <div class="social-media">
                    <a href="#" class="btn btn-primary"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-primary"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="btn btn-primary"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="btn btn-primary"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <a href="#" class="btn btn-primary mt-3">Shop now</a>
            </div>
            <div class="col-md-6">
                <img src="./assets/img/hero.jpg" alt="Hero Image" class="img-fluid">
            </div>
        </div>

        <!-- Feature products -->
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center text-primary my-4">Feature products</h2>
                <div class="row">
                    <?php
                    // select random 4 products from the database
                    $featuredProductsQuery = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
                    $featuredProductsResult = $conn->query($featuredProductsQuery);
                    while ($product = $featuredProductsResult->fetch_object()):
                    ?>
                        <div class="col-md-3">
                            <div class="card mb-4 h-100">
                                <img src="./assets/images/products/<?= $product->image ?>" alt="<?= $product->name ?>"
                                    class="card-img-top img-thumbnail p-2"
                                    style="height: 100%; height: 200px; object-fit: contain;">
                                <div class="card-body">
                                    <h5 class="card-title text-truncate"
                                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <?= $product->name ?>
                                    </h5>
                                    <p class="card-text">Price: $<?= number_format($product->sale_price) ?></p>
                                    <a href="./single-product.php?id=<?= $product->id ?>" class="btn btn-primary">View
                                        Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

        <!-- new arrivals -->
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center text-primary my-4">New arrivals</h2>
                <div class="row">
                    <?php
                    // select latest 4 products from the database
                    $newArrivalQuery = "SELECT * FROM products ORDER BY created_at DESC LIMIT 4";
                    $newArrivalResult = $conn->query($newArrivalQuery);
                    while ($product = $newArrivalResult->fetch_object()):
                    ?>
                        <div class="col-md-3">
                            <div class="card mb-4 h-100">
                                <img src="./assets/images/products/<?= $product->image ?>" alt="<?= $product->name ?>"
                                    class="card-img-top img-thumbnail p-2"
                                    style="height: 100%; height: 200px; object-fit: contain;">
                                <div class="card-body">
                                    <h5 class="card-title text-truncate"
                                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <?= $product->name ?>
                                    </h5>
                                    <p class="card-text">Price: $<?= number_format($product->sale_price) ?></p>
                                    <a href="./single-product.php?id=<?= $product->id ?>" class="btn btn-primary">View
                                        Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

        <!-- best sellers -->
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center text-primary my-4">Best sellers</h2>
            </div>
        </div>

        <!--sale-->
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center text-primary my-4">Sale</h2>
            </div>
        </div>


    </div>
</div>







<?php
require_once './components/footer.php';

?>