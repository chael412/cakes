<?php include ('partials/menu.php'); ?>
<div class="wrapper">
    <h1>Manage Order</h1>
</div>

<br /><br /><br />

<?php
if (isset($_SESSION['update'])) {
    echo $_SESSION['update'];
    unset($_SESSION['update']);
}
?>
<br><br>

<table class="content-table">
    <tr>
        <th>S.N.</th>
        <th>Ref#</th>
        <th>Cake</th>
        <th>Price</th>
        <th>Qty.</th>
        <th>Total</th>
        <th>Order Date</th>
        <th>Status</th>
        <th>Customer Name</th>
        <th>Contact</th>
        <th>Email</th>
        <th>Address</th>
        <th>Payment Method</th>
        <th>Delivery Option</th>
        <th>Update Orders</th>
    </tr>

    <?php
    //Get all the orders from database
    $sql = "SELECT users.*, tbl_order.*, rf.ref_no as rf_no FROM users 
INNER JOIN tbl_order ON users.id=tbl_order.u_id
INNER JOIN ref_no rf ON tbl_order.ref_no = rf.ref_id"; // DIsplay the Latest Order at First
    //Execute Query
    $res = mysqli_query($conn, $sql);
    //Count the Rows
    $count = mysqli_num_rows($res);

    $sn = 1; //Create a Serial Number and set its initail value as 1
    
    if ($count > 0) {
        //Order Available
        while ($row = mysqli_fetch_assoc($res)) {
            //Get all the order details
            $id = $row['id'];
            $ref_no = $row['rf_no'];
            $cake = $row['cake'];
            $price = $row['price'];
            $qty = $row['qty'];
            $total = $row['total'];
            $order_date = $row['order_date'];
            $status = $row['status'];
            $customer_name = $row['customer_name'];
            $customer_contact = $row['customer_contact'];
            $customer_email = $row['customer_email'];
            $customer_address = $row['customer_address'];
            $payment_method = $row['payment_method'];
            $delivery_option = $row['delivery_option'];

            ?>

            <tr>
                <td><?php echo $sn++; ?>. </td>
                <td><?php echo $ref_no; ?></td>
                <td><?php echo $cake; ?></td>
                <td><?php echo $price; ?></td>
                <td><?php echo $qty; ?></td>
                <td><?php echo $total; ?></td>
                <td><?php echo $order_date; ?></td>

                <td>
                    <?php
                    // Ordered, On Delivery, Delivered, Cancelled
            
                    if ($status == "Ordered") {
                        echo "<label>$status</label>";
                    } elseif ($status == "On Delivery") {
                        echo "<label style='color: orange;'>$status</label>";
                    } elseif ($status == "Delivered") {
                        echo "<label style='color: green;'>$status</label>";
                    } elseif ($status == "Cancelled") {
                        echo "<label style='color: red;'>$status</label>";
                    }
                    ?>
                </td>

                <td><?php echo $customer_name; ?></td>
                <td><?php echo $customer_contact; ?></td>
                <td><?php echo $customer_email; ?></td>
                <td><?php echo $customer_address; ?></td>
                <td><?= $payment_method ?></td>
                <td><?= $delivery_option ?></td>
                <td>
                    <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>"><img
                            src="../images/icons/update.png" /></a>
                </td>
            </tr>

            <?php

        }
    } else {
        //Order not Available
        echo "<tr><td colspan='12' class='error'>Orders not Available</td></tr>";
    }
    ?>


</table>




<?php include ('partials/footer.php'); ?>