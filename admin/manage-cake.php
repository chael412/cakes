<?php include ('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Cake</h1>

        <br /><br />

        <!-- Button to Add Admin -->
        <a href="<?php echo SITEURL; ?>admin/add-cake.php" class="btn-primary">Add Cake</a>

        <br /><br /><br />

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        if (isset($_SESSION['unauthorize'])) {
            echo $_SESSION['unauthorize'];
            unset($_SESSION['unauthorize']);
        }

        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        ?>

        <table class="content-table">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Availability</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>

            <?php
            //Create a SQL Query to Get all the Food
            $sql = "SELECT * FROM tbl_cake";

            //Execute the qUery
            $res = mysqli_query($conn, $sql);

            //Count Rows to check whether we have foods or not
            $count = mysqli_num_rows($res);

            //Create Serial Number VAriable and Set Default VAlue as 1
            $sn = 1;

            if ($count > 0) {
                //We have food in Database
                //Get the Foods from Database and Display
                while ($row = mysqli_fetch_assoc($res)) {
                    //get the values from individual columns
                    $id = $row['id'];
                    $title = $row['title'];
                    $stock = $row['quantity'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                    ?>

                    <tr>
                        <td><?php echo $sn++; ?>. </td>
                        <td><?php echo $title; ?></td>
                        <td><?= $stock ?></td>
                        <td>₱<?php echo $price; ?></td>
                        <td>
                            <?php
                            //CHeck whether we have image or not
                            if ($image_name == "") {
                                //WE do not have image, DIslpay Error Message
                                echo "<div class='error'>Image not Added.</div>";
                            } else {
                                //WE Have Image, Display Image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/cakes/<?php echo $image_name; ?>" width="100px">
                                <?php
                            }
                            ?>
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-cake.php?id=<?php echo $id; ?>">
                                <image src="../images/icons/update.png">
                            </a>
                        </td>
                        <td>
                            <a
                                href="<?php echo SITEURL; ?>admin/delete-cake.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>">
                                <image src="../images/icons/delete.png" />
                            </a>
                        </td>
                    </tr>

                    <?php
                }
            } else {
                //Food not Added in Database
                echo "<tr> <td colspan='7' class='error'>Cake not Added Yet. </td> </tr>";
            }

            ?>


        </table>
    </div>

</div>

<?php include ('partials/footer.php'); ?>