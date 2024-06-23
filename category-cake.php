<?php include('partials-front/menu.php'); ?>

<?php 
    //Check whether id is passed or not
    if(isset($_GET['category_id']))
    {
        //Category id is set and get the id
        $category_id = $_GET['category_id'];
        // Get the Category Title Based on Category ID
        $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Get the value from Database
        $row = mysqli_fetch_assoc($res);
        //Get the Title
        $category_title = $row['title'];
    }
    else
    {
        //Category not passed
        //Redirect to Home page
        header('location:'.SITEURL);
    }
?>


<!-- Cake SEARCH Section Starts Here -->
<section class="cake-search text-center">
    <div class="container">
        
        <h2>Cakes on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

    </div>
</section>
<!-- Cake SEARCH Section Ends Here -->



<!-- Cake Menu Section Starts Here -->
<section class="cake-menu">
    <div class="container">
        <h2 class="text-center">Cake Menu</h2>

        <?php 
        
            //Create SQL Query to Get cakes based on Selected Category
            $sql2 = "SELECT * FROM tbl_cake WHERE category_id=$category_id";

            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            //Count the Rows
            $count2 = mysqli_num_rows($res2);

            //Check whether cake is available or not
            if($count2>0)
            {
                //Cake is Available
                while($row2=mysqli_fetch_assoc($res2))
                {
                    $id = $row2['id'];
                    $title = $row2['title'];
                    $price = $row2['price'];
                    $description = $row2['description'];
                    $image_name = $row2['image_name'];
                    ?>
                    
                    <div class="cake-menu-box">
                        <div class="cake-menu-img">
                            <?php 
                                if($image_name=="")
                                {
                                    //Image not Available
                                    echo "<div class='error'>Image not Available.</div>";
                                }
                                else
                                {
                                    //Image Available
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Cake Image" class="img-responsive img-curve">
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
                //Cake not available
                echo "<div class='error'>Cake not Available.</div>";
            }
        
        ?>

        

        <div class="clearfix"></div>

        

    </div>

</section>
<!-- Cake Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
