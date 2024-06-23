<?php
include ('partials-front/menu.php');

// Check if the user is logged in
if (!isset($_SESSION["u_id"])) {
    header('location:login.php');
    exit();
}




// Check if the selected items are posted
if (!isset($_POST['selected_items']) || empty($_POST['selected_items'])) {
    echo "<p class='error'>No items selected for checkout.</p>";
    include ('partials-front/footer.php');
    exit();
}

// Fetch selected cart items
$selected_items = $_POST['selected_items'];
$placeholders = implode(',', array_fill(0, count($selected_items), '?'));
$sql_cart = "SELECT c.id as cart_id, c.cake_id, c.qty, k.title, k.price, k.image_name 
             FROM tbl_cart c 
             JOIN tbl_cake k ON c.cake_id = k.id 
             WHERE c.id IN ($placeholders)";

// Prepare the statement
$stmt = $conn->prepare($sql_cart);
$types = str_repeat('i', count($selected_items));
$stmt->bind_param($types, ...$selected_items);
$stmt->execute();
$res_cart = $stmt->get_result();

// Check if cart is empty
if ($res_cart->num_rows == 0) {
    echo "<p class='error'>No valid items selected for checkout.</p>";
    include ('partials-front/footer.php');
    exit();
}
?>

<!-- Cake Order Section Starts Here -->
<section class="cake-order">
    <div class="container">
        <h2 class="text-center text-white">Please confirm to place order</h2>

        <form method="POST" action="receipts.php" class="order">
            <?php
            $total_order_price = 0;
            while ($row_cart = $res_cart->fetch_assoc()) {
                $cart_id = $row_cart['cart_id'];
                $cake_id = $row_cart['cake_id'];
                $title = $row_cart['title'];
                $price = $row_cart['price'];
                $qty = $row_cart['qty'];
                $image_name = $row_cart['image_name'];
                $total_price = $price * $qty;
                $total_order_price += $total_price;
                ?>
                <fieldset>
                    <legend style="color:white;">Selected Cake</legend>

                    <div class="cake-menu-img">
                        <?php
                        if ($image_name == "") {
                            echo "<div class='error'>Image not Available.</div>";
                        } else {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/cakes/<?php echo $image_name; ?>" alt="<?php echo $title; ?>"
                                class="img-responsive img-curve">
                            <?php
                        }
                        ?>
                    </div>

                    <div class="cake-menu-desc">
                        <h3 style="color:white;"><?php echo $title; ?></h3>

                        <input type="hidden" name="cart_ids[]" value="<?php echo $cart_id; ?>">
                        <input type="hidden" name="cake_ids[]" value="<?php echo $cake_id; ?>">

                        <p class="food-price" style="color:white;">₱<?php echo $price; ?></p>
                        <input type="hidden" name="price[]" value="<?php echo $price; ?>">

                        <div class="order-label" style="color:white;">Quantity: <?php echo $qty; ?></div>
                        <input type="hidden" name="qty[]" value="<?php echo $qty; ?>">
                    </div>
                </fieldset>
            <?php } ?>

            <fieldset>
                <p class="food-price" style="color:white;">Total Order Price: ₱<?php echo $total_order_price; ?></p>
                <input type="hidden" name="total_order_price" value="<?php echo $total_order_price; ?>">

                <div class="form-group" style="color: white; margin-top:12px">
                    <label for="delivery_option">Delivery Option:</label><br>
                    <label><input type="radio" name="delivery_option" value="pickup" checked required> Pick-up</label>
                    <label><input type="radio" name="delivery_option" value="delivery" required> Delivery</label>
                </div>

                <div class="form-group" style="color: white; margin-top:12px">
                    <label for="payment_method">Payment Method:</label><br>
                    <label><input type="radio" name="payment_method" value="gcash" required> GCash</label>
                    <label><input type="radio" name="payment_method" value="cash" required> Cash on Delivery</label>
                </div>

                <div class="form-group" id="gcash_no_field" style="display: none; margin-top: 12px">
                    <label style="color: white">GCash No.</label><br>
                    <img src="./images/gcash_qr.jpg" alt="gcash qr" width="200">
                </div>


                <input type="hidden" name="userId" value="<?= $_SESSION["u_id"]; ?>">
                <button style="margin-top: 15px" type="submit" class="btn btn-primary"
                    name="order_checkout">Checkout</button>

            </fieldset>
        </form>


    </div>
</section>
<!-- Cake Order Section Ends Here -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');
        var gcashNoField = document.getElementById('gcash_no_field');

        for (var i = 0; i < paymentMethodRadios.length; i++) {
            paymentMethodRadios[i].addEventListener('change', function () {
                if (this.value === 'gcash') {
                    gcashNoField.style.display = 'block';
                } else {
                    gcashNoField.style.display = 'none';
                }
            });
        }
    });
</script>


<?php include ('partials-front/footer.php'); ?>