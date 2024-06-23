<?php include ('partials-front/menu.php'); ?>

<!-- CAKE SEARCH Section Starts Here -->
<section class="cake-search text-center">
    <div class="container">

        <form action="<?php echo SITEURL; ?>cake-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Cake.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>

    </div>
</section>
<!-- CAKE SEARCH Section Ends Here -->

<?php
if (isset($_SESSION['order'])) {
    echo $_SESSION['order'];
    unset($_SESSION['order']);
}
?>

<!-- CATEGORIES Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Cakes</h2>

        <?php
        //Create SQL Query to Display Categories from Database
        $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";
        //Execute the Query
        $res = mysqli_query($conn, $sql);
        //Count rows to check whether the category is available or not
        $count = mysqli_num_rows($res);

        if ($count > 0) {
            //Categories Available
            while ($row = mysqli_fetch_assoc($res)) {
                //Get the Values like id, title, image_name
                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];
                ?>

                <a href="<?php echo SITEURL; ?>category-cake.php?category_id=<?php echo $id; ?>">
                    <div class="box-3 float-container">
                        <?php
                        //Check whether Image is available or not
                        if ($image_name == "") {
                            //Display Message
                            echo "<div class='error'>Image not Available</div>";
                        } else {
                            //Image Available
                            ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt=""
                                class="img-responsive img-curve">
                            <?php
                        }
                        ?>


                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                    </div>
                </a>

                <?php
            }
        } else {
            //Categories not Available
            echo "<div class='error'>Category not Added.</div>";
        }
        ?>


        <div class="clearfix"></div>
    </div>
</section>
<!-- CATEGORIES Section Ends Here -->



<!-- CAKE MENU Section Starts Here -->
<section class="cake-menu">
    <div class="container">
        <h2 class="text-center">Featured Cakes</h2>

        <?php

        //Getting Cakes from Database that are active and featured
        //SQL Query
        $sql2 = "SELECT * FROM tbl_cake WHERE active='Yes' AND featured='Yes' LIMIT 6";

        //Execute the Query
        $res2 = mysqli_query($conn, $sql2);

        //Count Rows
        $count2 = mysqli_num_rows($res2);

        //Check whether cake available or not
        if ($count2 > 0) {
            //Cake Available
            while ($row = mysqli_fetch_assoc($res2)) {
                //Get all the values
                $id = $row['id'];
                $title = $row['title'];
                $price = $row['price'];
                $qty_cake = $row['quantity'];
                $description = $row['description'];
                $image_name = $row['image_name'];
                ?>

                <div class="cake-menu-box">
                    <div class="cake-menu-img">
                        <?php
                        //Check whether image available or not
                        if ($image_name == "") {
                            //Image not Available
                            echo "<div class='error'>Image not available.</div>";
                        } else {
                            //Image Available
                            ?>
                            <img src="<?php echo SITEURL; ?>images/cakes/<?php echo $image_name; ?>" alt="<?php echo $title; ?>"
                                class="img-responsive img-curve">
                            <?php
                        }
                        ?>

                    </div>

                    <div class="cake-menu-desc">
                        <h4><?php echo $title; ?>
                            <span style="background: #e2e8f0; color: #15803d; padding: 3px 5px">(<?= $qty_cake ?>)</span>
                        </h4>
                        <p class="cake-price">₱<?php echo $price; ?></p>
                        <p class="cake-detail">
                            <?php echo $description; ?>
                        </p>
                        <br>
                        <?php if ($qty_cake > 0) { ?>
                            <a href="<?php echo SITEURL; ?>order.php?cake_id=<?php echo $id; ?>" class="btn btn-primary">Order
                                Now</a>
                            <a href="<?php echo SITEURL; ?>add-to-cart.php?cake_id=<?php echo $id; ?>" class="btn btn-secondary">Add
                                to Cart</a>
                        <?php } else { ?>
                            <button class="btn btn-secondary" disabled>Out of Stock</button>
                        <?php } ?>

                        
                    </div>
                </div>

                <?php
            }
        } else {
            //Cake Not Available 
            echo "<div class='error'>Cake not available.</div>";
        }

        ?>

        <div class="clearfix"></div>

    </div>

    <p class="text-center">
        <a href="<?php echo SITEURL; ?>cakes.php">See All Cakes</a>
    </p>
</section>
<!-- CAKE MENU Section Ends Here -->


<?php include ('partials-front/footer.php'); ?>