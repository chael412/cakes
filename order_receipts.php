<?php
// Include the menu and establish database connection
include ('partials-front/menu.php');

// Check if order_id is set in the URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $query_ref = "SELECT rf.ref_no
          FROM tbl_order o
          INNER JOIN ref_no rf ON o.ref_no = rf.ref_id
          WHERE o.id = $order_id";

    $result_ref = mysqli_query($conn, $query_ref);




    // Fetch order details
    $order_query = "SELECT * FROM tbl_order WHERE id = ?";
    $stmt = mysqli_prepare($conn, $order_query);
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $order = mysqli_fetch_assoc($result);
        $cake = $order['cake'];
        $price = $order['price'];
        $qty = $order['qty'];
        $total = $order['total'];
        $status = $order['status'];
        $payment_method = $order['payment_method'];
        $delivery_option = $order['delivery_option'];
        $gcash_no = $order['gcash_no']; // If you have this column in your tbl_order table

        // Fetch user details
        $u_id = $order['u_id'];
        $user_query = "SELECT customer_name, customer_contact, customer_address FROM users WHERE id = ?";
        $stmt_user = mysqli_prepare($conn, $user_query);
        mysqli_stmt_bind_param($stmt_user, "i", $u_id);
        mysqli_stmt_execute($stmt_user);
        $result_user = mysqli_stmt_get_result($stmt_user);
        $user_details = mysqli_fetch_assoc($result_user);

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
                <p><?php echo date('F j, Y'); ?></p>
                <h2>Order Receipt</h2>
                <h4>Mrs. G</h4>

                <div class="order-details">
                    <?php
                    if ($result_ref) {
                        // Fetch row as an associative array
                        $row_receipt = mysqli_fetch_assoc($result_ref);

                        if ($row_receipt) {
                            ?>
                            <strong>Reference#:</strong> <?= $row_receipt['ref_no']; ?> <br>
                            <?php

                        } else {
                            echo "No results found.";
                        }
                        // Free$result_ref set
                        mysqli_free_result($result_ref);
                    } else {
                        echo "Error executing query: " . mysqli_error($conn);
                    }
                    ?>


                    <strong>Delivery Option:</strong> <?php echo htmlspecialchars($delivery_option); ?><br>
                    <strong>Payment Method:</strong> <?php echo htmlspecialchars($payment_method); ?><br>
                    <?php if ($payment_method == 'gcash'): ?>
                        <strong>GCash Number:</strong> <?php echo htmlspecialchars($gcash_no); ?><br>
                    <?php endif; ?>
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
                        <tr>
                            <td><?php echo htmlspecialchars($cake); ?></td>
                            <td>₱<?php echo number_format($price, 2); ?></td>
                            <td><?php echo htmlspecialchars($qty); ?></td>
                            <td>₱<?php echo number_format($total, 2); ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="total">
                    <strong>Total:</strong> ₱<?php echo number_format($total, 2); ?>
                </div>
                <div class="customer-details">
                    Customer Name: <?php echo htmlspecialchars($user_details['customer_name']); ?><br>
                    Contact No: <?php echo htmlspecialchars($user_details['customer_contact']); ?><br>
                </div>
                <div style="text-align: center">
                    <p>Thank you for your order!</p>
                </div>
            </div>

            <div style="display:flex; justify-content:center; margin-top:15px;">
                <button id="print"
                    style="background-color: #4CAF50; color: white; border: none; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 12px;">
                    Print
                </button>
            </div>

            <script>
                document.getElementById('print').addEventListener('click', function () {
                    window.print();
                });
            </script>

        </body>

        </html>
        <?php

        // End of HTML receipt

    } else {
        echo "Error fetching order details: " . mysqli_error($conn);
    }

} else {
    // Redirect if order_id is not set
    header('location:' . SITEURL);
    exit();
}

// Include footer
include ('partials-front/footer.php');
?>