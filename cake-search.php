<?php include('partials-front/menu.php'); ?>

<!-- Cake SEARCH Section Starts Here -->
<section class="cake-search text-center">
    <div class="container">
        <?php 

            //Get the Search Keyword
            $search = mysqli_real_escape_string($conn, $_POST['search']);
        
        ?>

        <h2>Cakes on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

    </div>
</section>
<!-- Cake SEARCH Section Ends Here -->



<!-- Cake Menu Section Starts Here -->
<section class="cake-menu">
    <div class="container">
        <h2 class="text-center">Cake Menu</h2>

        <?php 

            //SQL Query to Get cakes based on search keyword
            $sql = "SELECT * FROM tbl_cake WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

            //Execute the Query
            $res = mysqli_query($conn, $sql);

            //Count Rows
            $count = mysqli_num_rows($res);

            //Check whether cake available or not
            if($count>0)
            {
                //Cake Available
                while($row=mysqli_fetch_assoc($res))
                {
                    //Get the details
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    ?>

                    <div class="cake-menu-box">
                        <div class="cake-menu-img">
                            <?php 
                                // Check whether image name is available or not
                                if($image_name=="")
                                {
                                    //Image not Available
                                    echo "<div class='error'>Image not Available.</div>";
                                }
                                else
                                {
                                    //Image Available
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/cakes/<?php echo $image_name; ?>" alt="Cake Image" class="img-responsive img-curve">
                                    <?php 

                                }
                            ?>
                            
                        </div>

                        <div class="cake-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="cake-price">₱<?php echo $price; ?></p>
                            <p class="cake-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="<?php echo SITEURL; ?>order.php?cake_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

                    <?php
                }
            }
            else
            {
                //Cake Not Available
                echo "<div class='error'>Cake not found.</div>";
            }
        
        ?>

        

        <div class="clearfix"></div>

        

    </div>

</section>
<!-- Cake Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
