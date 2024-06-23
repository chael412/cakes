<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mrs. G</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="http://localhost/cakes/" title="Logo">
                    <img src="images/cakes/logo.png" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>
            <br>
            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="<?php echo SITEURL; ?>">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>categories.php">Categories</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>cakes.php">Cakes</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>cart.php">Cart</a>
                    </li>
                    <li>            
                        <?php
                        if(empty($_SESSION["u_id"]))
                        {
                            echo '<a href="login.php" class="nav-link active">Login</a>';
                        }
                        else
                        {
                            echo '<a href="myorders.php" class="nav-link active">My Orders</a>';
                            echo '<a href="logout.php" class="nav-link active">Logout</a>';
                        }
                        ?>
                    </li>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->
