<?php include('partials-front/menu.php'); ?>

<!-- Categories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Cakes</h2>

        <?php 
            // Display all the categories that are active
            // SQL Query
            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

            // Execute the Query
            $res = mysqli_query($conn, $sql);

            // Check if the query was successful
            if($res == true) {
                // Count Rows
                $count = mysqli_num_rows($res);

                // Check whether categories are available or not
                if($count > 0) {
                    // Categories Available
                    while($row = mysqli_fetch_assoc($res)) {
                        // Get the Values
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                        
                        <a href="<?php echo SITEURL; ?>category-cake.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php 
                                    if($image_name == "") {
                                        // Image not Available
                                        echo "<div class='error'>Image not found.</div>";
                                    } else {
                                        // Image Available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                                
                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>

                        <?php
                    }
                } else {
                    // Categories Not Available
                    echo "<div class='error'>Category not found.</div>";
                }
            } else {
                // Query failed
                echo "<div class='error'>Failed to execute query: " . mysqli_error($conn) . "</div>";
            }
        ?>
        
        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
