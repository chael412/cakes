<?php
ob_start(); // Start output buffering

// Include the menu
include ('partials-front/menu.php');

// Check if the user is logged in
if (!isset($_SESSION["u_id"])) {
    header('location:login.php');
    exit();
}

// Function to fetch user details
function getUserDetails($conn, $u_id)
{
    $sql = "SELECT customer_name, customer_contact, customer_address FROM users WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $u_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $customer_name, $customer_contact, $customer_address);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return [
        'customer_name' => $customer_name,
        'customer_contact' => $customer_contact,
        'customer_address' => $customer_address
    ];
}

// Check whether cake id is set or not
if (isset($_GET['cake_id'])) {
    // Get the cake id and details of the selected cake
    $cake_id = $_GET['cake_id'];

    // Get the details of the selected cake
    $sql = "SELECT * FROM tbl_cake WHERE id=$cake_id";
    // Execute the query
    $res = mysqli_query($conn, $sql);
    // Count the rows
    $count = mysqli_num_rows($res);
    // Check whether the data is available or not
    if ($count == 1) {
        // We have data
        // Get the data from the database
        $row = mysqli_fetch_assoc($res);

        $title = $row['title'];
        $price = $row['price'];
        $image_name = $row['image_name'];
    } else {
        // Cake not available
        // Redirect to home page or show error message
        $_SESSION['order'] = "<div class='error text-center'>Cake not available for order.</div>";
        header('location:' . SITEURL);
        exit();
    }
} else {
    // Redirect to homepage if cake_id is not set
    header('location:' . SITEURL);
    exit();
}

// Fetch user details
$userDetails = getUserDetails($conn, $_SESSION['u_id']);
$customer_name = $userDetails['customer_name'];
$customer_contact = $userDetails['customer_contact'];
$customer_address = $userDetails['customer_address'];

?>

<!-- Cake Order Section Starts Here -->
<section class="cake-order">
    <div class="container">
        <h2 class="text-center text-white">Please confirm to place order</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend style="color:white;">Selected Cake</legend>
                <input type="hidden" name="cakeId" value="<?= $cake_id; ?>">

                <div class="cake-menu-img">
                    <?php
                    // Display cake image
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
                    <input type="hidden" name="cake" value="<?php echo $title; ?>">

                    <p class="food-price" style="color:white;">₱<?php echo $price; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">

                    <div class="order-label" style="color:white;">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>

                    <div class="order-label" style="color:white;">Payment Method</div>
                    <select name="payment_method" id="payment_method" class="input-responsive" required
                        onchange="toggleGcashField()">
                        <option value="cod">Cash on Delivery</option>
                        <option value="gcash">GCash</option>
                    </select>

                    <div class="form-group" id="gcash_no_field" style="display: none; margin-top: 12px">
                        <label style="color: white">GCash No.</label><br>
                        <img src="./images/gcash_qr.jpg" alt="gcash qr" width="200">
                    </div>


                    <div class="order-label" style="color:white;">Delivery Option</div>
                    <input type="radio" name="delivery_option" value="pickup" checked> Pick-up
                    <input type="radio" name="delivery_option" value="delivery"> Delivery

                    <div class="order-label" style="color:white;">Full Name</div>
                    <input type="text" name="fullname" class="input-responsive" value="<?php echo $customer_name; ?>"
                        required>

                    <div class="order-label" style="color:white;">Contact Number</div>
                    <input type="text" name="contact" class="input-responsive" value="<?php echo $customer_contact; ?>"
                        required>

                    <div class="order-label" style="color:white;">Address</div>
                    <textarea name="address" rows="5" class="input-responsive"
                        required><?php echo $customer_address; ?></textarea>
                </div>
            </fieldset>

            <fieldset>
                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>
        </form>

        <?php
        // Check whether submit button is clicked or not
        if (isset($_POST['submit'])) {
            // Get all the details from the form
            $cakeId = $_POST['cakeId'];
            $cake = $_POST['cake'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $payment_method = $_POST['payment_method'];
            $delivery_option = isset($_POST['delivery_option']) ? $_POST['delivery_option'] : 'pickup';
            $total = $price * $qty; // total = price x qty 
            $status = "Ordered";  // Ordered, On Delivery, Delivered, Cancelled
            $u_id = $_SESSION["u_id"];


            $gcash_no = ($payment_method == 'gcash') ? '09991931710' : '';

            // Save the order in the database
            // Save the order in the database
            $sql2 = "INSERT INTO tbl_order (cake, price, qty, total, status, u_id, payment_method, delivery_option, gcash_no)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql2);

            // Update quantity in tbl_cake
            $update_cake_query = "UPDATE tbl_cake SET quantity = quantity - ? WHERE id = ?";
            $update_stmt = mysqli_prepare($conn, $update_cake_query);

            if ($stmt && $update_stmt) {
                mysqli_stmt_bind_param($stmt, "sidisssss", $cake, $price, $qty, $total, $status, $u_id, $payment_method, $delivery_option, $gcash_no);
                mysqli_stmt_bind_param($update_stmt, "ii", $qty, $cakeId);

                if (mysqli_stmt_execute($stmt)) {
                    // Get the generated order_id
                    $order_id = mysqli_insert_id($conn);

                    // Execute update cake query
                    mysqli_stmt_execute($update_stmt);

                    // Check if the query executed successfully
                    if (mysqli_stmt_affected_rows($stmt) > 0 && mysqli_stmt_affected_rows($update_stmt) > 0) {
                        // Query executed and order saved
                        ?>
                        <script>
                            alert("Cake Ordered Successfully.");
                            window.location.href = 'order_receipts.php?order_id=<?php echo $order_id; ?>'; 
                        </script>
                        <?php
                        exit();
                    } else {
                        // Failed to save order or update cake quantity
                        $_SESSION['order'] = "<div class='error text-center'>Failed to Order Cake or Update Quantity.</div>";
                        header('location:' . SITEURL);
                        exit();
                    }
                } else {
                    // Execution failed
                    $_SESSION['order'] = "<div class='error text-center'>" . mysqli_error($conn) . "</div>"; // Get MySQL error message
                    header('location:' . SITEURL);
                    exit();
                }

                mysqli_stmt_close($stmt);
                mysqli_stmt_close($update_stmt);
            } else {
                // Error in prepared statement
                $_SESSION['order'] = "<div class='error text-center'>Failed to prepare statement.</div>";
                header('location:' . SITEURL);
                exit();
            }


        }
        ?>
    </div>
</section>
<!-- Cake Order Section Ends Here -->
<?php include ('partials-front/footer.php'); ?>
<script>
    function toggleGcashField() {
        var paymentMethod = document.getElementById("payment_method").value;
        var gcashField = document.getElementById("gcash_no_field");

        if (paymentMethod === "gcash") {
            gcashField.style.display = "block";
        } else {
            gcashField.style.display = "none";
        }
    }
</script>



<?php
ob_end_flush(); // Flush the output buffer
?>