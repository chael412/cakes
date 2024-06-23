<?php include ('partials-front/menu.php'); ?>

<style>
    .cart {
        padding: 40px 0;
    }

    .cart .container {
        max-width: 800px;
        margin: auto;
        background: #f7f7f7;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .cart h2 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: center;
    }

    .table th {
        background-color: #333;
        color: #fff;
    }

    .table td {
        border-bottom: 1px solid #ccc;
    }

    .table .img-responsive {
        max-width: 100%;
        height: auto;
    }

    .table .img-curve {
        border-radius: 5px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #5cb85c;
        color: #fff;
    }

    .btn-danger {
        background-color: #d9534f;
        color: #fff;
    }

    .text-right {
        text-align: right;
    }

    .error {
        color: #d9534f;
    }
</style>

<!-- Cart Section Starts Here -->
<section class="cart">
    <div class="container">
        <h2 class="text-center">Your Cart</h2>

        <form action="checkout.php" method="POST">
            <table class="table table-border">
                <tr>
                    <th>Select</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>

                <?php
                // Check if the user is logged in
                if (isset($_SESSION["u_id"])) {
                    $u_id = $_SESSION["u_id"];
                } else {
                    // Redirect to login page if not logged in
                    header('location:' . SITEURL . 'login.php');
                    exit();
                }

                // Fetch items from the cart for the logged-in user
                $sql = "SELECT * FROM tbl_cart WHERE u_id='$u_id'";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                $total = 0;

                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $cart_id = $row['id'];
                        $cake_id = $row['cake_id'];
                        $qty = $row['qty'];

                        // Get cake details
                        $sql2 = "SELECT * FROM tbl_cake WHERE id=$cake_id";
                        $res2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($res2);

                        $title = $row2['title'];
                        $price = $row2['price'];
                        $image_name = $row2['image_name'];
                        $subtotal = $price * $qty;
                        $total += $subtotal;
                        ?>

                        <tr>
                            <td><input type="checkbox" name="selected_items[]" value="<?php echo $cart_id; ?>"></td>
                            <td>
                                <?php
                                if ($image_name != "") {
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/cakes/<?php echo $image_name; ?>"
                                        alt="<?php echo $title; ?>" class="img-responsive img-curve" style="width: 50px;">
                                    <?php
                                } else {
                                    echo "<div class='error'>Image not Available.</div>";
                                }
                                ?>
                            </td>
                            <td><?php echo $title; ?></td>
                            <td>₱<?php echo $price; ?></td>
                            <td>
                                <input type="number" value="<?php echo $qty; ?>" class="quantity"
                                    data-cart-id="<?php echo $cart_id; ?>">
                            </td>
                            <td class="item-total">₱<?php echo $subtotal; ?></td>
                            <td>
                                <a href="remove-from-cart.php?cart_id=<?php echo $cart_id; ?>" class="btn btn-danger">Remove</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='7' class='error'>Your Cart is Empty.</td></tr>";
                }
                ?>
                <tr>
                    <td colspan="5" class="text-right">Total</td>
                    <td class="cart-total">₱<?php echo $total; ?></td>
                    <td></td>
                </tr>
            </table>
            <input type="submit" name="proceed" value="Proceed to Checkout" class="btn btn-primary">
        </form>
    </div>
</section>
<!-- Cart Section Ends Here -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('.quantity').change(function () {
            var cartId = $(this).data('cart-id');
            var quantity = $(this).val();
            var $this = $(this);
            var previousQuantity = $this.data('previous-quantity');

            $.ajax({
                url: 'update-cart.php',
                method: 'POST',
                data: {
                    cart_id: cartId,
                    quantity: quantity
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status == 'success') {
                        // Update the subtotal and total in the cart
                        $('input[data-cart-id="' + cartId + '"]').closest('tr').find('.item-total').text('₱' + data.subtotal);
                        $('.cart-total').text('₱' + data.total);
                        $this.data('previous-quantity', quantity); // Store the new quantity as previous
                    } else if (data.status == 'error') {
                        alert(data.message);
                        $this.val(previousQuantity); // Revert to previous quantity
                    } else {
                        alert('Failed to update cart. Please try again.');
                        $this.val(previousQuantity); // Revert to previous quantity
                    }
                },
                error: function () {
                    alert('Failed to update cart. Please try again.');
                    $this.val(previousQuantity); // Revert to previous quantity
                }
            });
        }).each(function () {
            $(this).data('previous-quantity', $(this).val()); // Store initial quantity as previous
        });
    });
</script>



<?php include ('partials-front/footer.php'); ?>