<?php include ('partials-front/menu.php'); ?>

<!-- CAKE Menu Section Starts Here -->
<section class="cake-menu">
    <div class="container">
        <h2 class="text-center">Cake Menu</h2>

        <?php
        //Display Cakes that are Active
        $sql = "SELECT * FROM tbl_cake WHERE active='Yes'";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Count Rows
        $count = mysqli_num_rows($res);

        //Check whether the cakes are available or not
        if ($count > 0) {
            //Cakes Available
            while ($row = mysqli_fetch_assoc($res)) {
                //Get the Values
                $id = $row['id'];
                $title = $row['title'];
                $description = $row['description'];
                $price = $row['price'];
                $image_name = $row['image_name'];
                $qty_cake = $row['quantity'];
                ?>

                <div class="cake-menu-box">
                    <div class="cake-menu-img">
                        <?php
                        //Check whether image available or not
                        if ($image_name == "") {
                            //Image not Available
                            echo "<div class='error'>Image not Available.</div>";
                        } else {
                            //Image Available
                            ?>
                            <img src="<?php echo SITEURL; ?>images/cakes/<?php echo $image_name; ?>" alt=""
                                class="img-responsive img-curve">
                            <?php
                        }
                        ?>

                    </div>

                    <div class="cake-menu-desc">
                        <h4><?php echo $title; ?> <span
                                style="background: #e2e8f0; color: #15803d; padding: 3px 5px">(<?= $qty_cake ?>)</span></h4>
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
            //Cake not Available
            echo "<div class='error'>Cake not found.</div>";
        }
        ?>

        <div class="clearfix"></div>

    </div>
</section>
<!-- CAKE Menu Section Ends Here -->

<?php include ('partials-front/footer.php'); ?>