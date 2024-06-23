<?php include('partials-front/menu.php'); ?>

<!-- Order Status Section Starts Here -->
<section class="order-status">
    <div class="container">
        <h2 class="text-center">Order Status</h2>

        <?php
        if(isset($_SESSION['order'])) {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
        ?>
        
        <a href="<?php echo SITEURL; ?>" class="btn btn-primary">Go to Home</a>
    </div>
</section>
<!-- Order Status Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
