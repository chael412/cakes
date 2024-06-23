<?php
// Database connection
include ('partials-front/menu.php');

if (isset($_POST['order_checkout'])) {
    $userId = $_POST['userId'];
    $total_price = $_POST['total_order_price'];
    $delivery_option = $_POST['delivery_option'];
    $payment_method = $_POST['payment_method'];

    $gcash_no = ($payment_method == 'gcash') ? '09991931710' : '';



    $user_cart_query = "SELECT * FROM tbl_cart cart
                        INNER JOIN tbl_cake cake ON cart.cake_id = cake.id
                        INNER JOIN users u ON cart.u_id = u.id
                        WHERE u_id = '$userId'";

    $user_query = "SELECT * FROM tbl_cart cart
                        INNER JOIN tbl_cake cake ON cart.cake_id = cake.id
                        INNER JOIN users u ON cart.u_id = u.id
                        WHERE u_id = '$userId' LIMIT 1";

    $ref_no = "SELECT * FROM tbl_order 
            INNER JOIN ref_no ON tbl_order.ref_no = ref_no.ref_id
            WHERE u_id = '$userId' LIMIT 1";

    $cart_run = mysqli_query($conn, $user_cart_query);
    $user_run = mysqli_query($conn, $user_query);
    $refno_run = mysqli_query($conn, $ref_no);

    if ($cart_run) {
        // Generate and insert reference number once
        function generateReferenceNumber($prefix, $length)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $prefix . $randomString;
        }

        $referenceNumber = generateReferenceNumber('mrsg-', 10);

        $query_ref = "INSERT INTO ref_no(ref_no) VALUES('$referenceNumber')";
        $ref_run = mysqli_query($conn, $query_ref);

        if ($ref_run) {
            $last_ref_id = mysqli_insert_id($conn);

            // Start HTML output for receipt
            ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <title>Order Receipt</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                    }

                    .receipt {
                        border: 1px solid #ccc;
                        padding: 20px;
                        width: 600px;
                        margin: 0 auto;
                    }

                    .receipt h2 {
                        text-align: center;
                    }

                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-bottom: 10px;
                    }

                    table,
                    th,
                    td {
                        border: 1px solid #ccc;
                        padding: 8px;
                        text-align: left;
                    }

                    th {
                        background-color: #f2f2f2;
                    }

                    .order-details {
                        margin-bottom: 10px;
                    }

                    .total {
                        text-align: right;
                    }

                    @media print {
                        body * {
                            visibility: hidden;
                        }

                        #receipt_print,
                        #receipt_print * {
                            visibility: visible;
                        }
                    }
                </style>
            </head>

            <body>

                <div class="receipt" id="receipt_print">
                    <p>
                        <?php
                        $currentDate = date('F j, Y');
                        echo $currentDate;
                        ?>
                    </p>
                    <h2>Order Receipt</h2>
                    <h4>Mrs. G</h4>
                    <div class="order-details">
                        <?php
                        if ($refno_run) {
                            $row = mysqli_fetch_assoc($refno_run);
                            $ref_no_value = $row['ref_no'];
                            ?>
                            <strong>Reference#:</strong> <?= $ref_no_value ?> <br>
                            <?php
                        }
                        ?>
                        <strong>Delivery Option:</strong> <?php echo $delivery_option; ?><br>
                        <strong>Payment Method:</strong> <?php echo $payment_method; ?><br>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_order = 0;
                            $orderSuccess = true;

                            while ($row = mysqli_fetch_assoc($cart_run)) {
                                $cake_id = $row['cake_id'];
                                $uid = $row['u_id'];
                                $cake = $row['title'];
                                $price = $row['price'];
                                $qty = $row['qty'];
                                $total = $price * $qty;
                                $total_order += $total;
                                $status = "Ordered";
                                $price = $row['price'];
                                $customer_name = $row['customer_name'];
                                $customer_contact = $row['customer_contact'];
                                $ref_no = $row['ref_no'];

                                // Check if the quantity of cakes is greater than 0
                                $check_quantity_query = "SELECT quantity FROM tbl_cake WHERE id = '$cake_id'";
                                $quantity_result = mysqli_query($conn, $check_quantity_query);
                                $quantity_row = mysqli_fetch_assoc($quantity_result);
                                $available_quantity = $quantity_row['quantity'];

                                if ($available_quantity > 0 && $available_quantity >= $qty) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($cake); ?></td>
                                        <td>₱<?php echo number_format($price, 2); ?></td>
                                        <td><?php echo htmlspecialchars($qty); ?></td>
                                        <td>₱<?php echo number_format($total, 2); ?></td>
                                    </tr>
                                    <?php

                                    $insert_orders_query = "INSERT INTO tbl_order (cake, price, qty, total, status, u_id, payment_method, delivery_option, gcash_no, ref_no)
                                    VALUES ('$cake', '$price', '$qty', '$total', '$status', '$userId', '$payment_method', '$delivery_option','$gcash_no', '$last_ref_id')";
                                    $orders_run = mysqli_query($conn, $insert_orders_query);

                                    // Update quantity in tbl_cake
                                    $update_cake_query = "UPDATE tbl_cake SET quantity = quantity - '$qty' WHERE id = '$cake_id'";
                                    $update_cake_run = mysqli_query($conn, $update_cake_query);

                                    if (!$orders_run || !$update_cake_run) {
                                        $orderSuccess = false;
                                        echo "Order failed: " . mysqli_error($conn);
                                        break;
                                    }
                                } else {
                                    $orderSuccess = false;
                                    echo "Insufficient stock for cake: " . htmlspecialchars($cake);
                                    break;
                                }
                            }

                            if ($orderSuccess) {
                                // Empty cart of selected user
                                $delete_cart_query = "DELETE FROM tbl_cart WHERE u_id = '$userId'";
                                $delete_cart_run = mysqli_query($conn, $delete_cart_query);

                                if ($delete_cart_run) {
                                    ?>
                                    <script>
                                        alert("Order placed successfully.");
                                    </script>
                                    <?php
                                } else {
                                    echo "Error emptying cart: " . mysqli_error($conn);
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="total">
                        <strong>Total:</strong> ₱<?php echo number_format($total_order, 2); ?>
                    </div>

                    <?php
                    if ($user_run) {
                        $user_row = mysqli_fetch_assoc($user_run);

                        if ($user_row) {
                            ?>
                            <div class="customer-details">
                                Customer Name: <?= $user_row['customer_name'] ?><br>
                                Contact No: <?= $user_row['customer_contact'] ?><br>
                            </div>
                            <?php
                        } else {
                            echo "No records found.";
                        }
                    } else {
                        echo "Query User failed: " . mysqli_error($conn);
                    }
                    ?>

                    <div>
                        <p style="text-align: center">
                            Thank you for your order!
                        </p>
                    </div>
                </div>
                <div style="display:flex; justify-content:center; margin-top:15px;">
                    <button id="print"
                        style="background-color: #4CAF50; color: white; border: none; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 12px;">Print</button>
                </div>

            </body>

            </html>
            <?php

            // End of HTML receipt

        } else {
            echo "Error inserting record in ref_no: " . mysqli_error($conn);
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<script src="/html2canvas.js"></script>
<script src="index.js"></script>