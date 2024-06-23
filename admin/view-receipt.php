<?php
// Database connection
include ('partials/menu.php');

if (isset($_GET['ref_id'])) {
    $refID = mysqli_real_escape_string($conn, $_GET['ref_id']);

    $order_query = "SELECT tbl_order.id AS order_id, users.customer_name, users.customer_contact, tbl_order.cake, tbl_order.price, tbl_order.qty, (tbl_order.price * tbl_order.qty) AS total, rf.ref_no as rf_no, tbl_order.delivery_option, tbl_order.payment_method
                    FROM users 
                    INNER JOIN tbl_order ON users.id = tbl_order.u_id
                    INNER JOIN ref_no rf ON tbl_order.ref_no = rf.ref_id
                    WHERE rf.ref_id = '$refID'";

    $order_run = mysqli_query($conn, $order_query);

    if ($order_run && mysqli_num_rows($order_run) > 0) {
        $row = mysqli_fetch_assoc($order_run);
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
            <div style="margin-top: 30px"></div>
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
                    <strong>Reference#:</strong> <?= htmlspecialchars($row['rf_no']) ?> <br>
                    <strong>Delivery Option:</strong> <?= htmlspecialchars($row['delivery_option']) ?><br>
                    <strong>Payment Method:</strong> <?= htmlspecialchars($row['payment_method']) ?><br>
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
                        do {
                            $item_total = $row['total'];
                            $total_order += $item_total;
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['cake']) ?></td>
                                <td>₱<?= number_format($row['price'], 2) ?></td>
                                <td><?= htmlspecialchars($row['qty']) ?></td>
                                <td>₱<?= number_format($item_total, 2) ?></td>
                            </tr>
                            <?php
                        } while ($row = mysqli_fetch_assoc($order_run));
                        ?>
                    </tbody>
                </table>
                <div class="total">
                    <strong>Total:</strong> ₱<?= number_format($total_order, 2) ?>
                </div>
                <div class="customer-details">
                    <?php
                    $user_query = "SELECT users.*, tbl_order.*, rf.ref_no as rf_no, rf.ref_id FROM users 
                            INNER JOIN tbl_order ON users.id=tbl_order.u_id
                            INNER JOIN ref_no rf ON tbl_order.ref_no = rf.ref_id
                            WHERE rf.ref_id = $refID
                            GROUP BY rf.ref_id LIMIT 1";
                    $user_run = mysqli_query($conn, $user_query);
                    ?>
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
                </div>
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
            <script>
                document.getElementById('print').addEventListener('click', function () {
                    window.print();
                });
            </script>
        </body>

        </html>
        <?php
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>