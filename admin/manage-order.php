<?php include ('partials/menu.php'); ?>
<div class="wrapper">
    <h1>Manage Order</h1>
</div>


<?php
if (isset($_SESSION['update'])) {
    echo $_SESSION['update'];
    unset($_SESSION['update']);
}
?>
<br>

<div style="display: flex; justify-content: center; margin-bottom: 30px">
    <table class="content-table">
        <tr>
            <th>S.N.</th>
            <th>Ref#</th>
            <th>Customer Name</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Payment Method</th>
            <th>Delivery Option</th>
            <th>View Orders</th>
            <th>View Receipts</th>
        </tr>

        <?php
        //Get all the orders from database
        $sql = "SELECT users.*, tbl_order.*, rf.ref_no as rf_no, rf.ref_id FROM users 
                INNER JOIN tbl_order ON users.id=tbl_order.u_id
                INNER JOIN ref_no rf ON tbl_order.ref_no = rf.ref_id
                GROUP BY rf.ref_id";

        //Execute Query
        $res = mysqli_query($conn, $sql);
        //Count the Rows
        $count = mysqli_num_rows($res);

        $sn = 1; //Create a Serial Number and set its initail value as 1
        
        if ($count > 0) {
            //Order Available
            while ($row = mysqli_fetch_assoc($res)) {
                //Get all the order details
                $id = $row['ref_id'];
                $ref_no = $row['rf_no'];
                $customer_name = $row['customer_name'];
                $order_date = $row['order_date'];
                $status = $row['status'];
                $payment_method = $row['payment_method'];
                $delivery_option = $row['delivery_option'];
                ?>

                <tr>
                    <td><?php echo $sn++; ?>. </td>
                    <td><?php echo $ref_no; ?></td>
                    <td><?php echo $customer_name; ?></td>
                    <td><?php echo $order_date; ?></td>
                    <td>
                        <?php
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
                    <td><?= $payment_method ?></td>
                    <td><?= $delivery_option ?></td>
                    <td>
                        <a href="<?php echo SITEURL; ?>admin/view-order.php?id=<?php echo $id; ?>"><img
                                src="../images/icons/show.png" width="35" /></a>
                    </td>
                    <td>
                        <a href="<?php echo SITEURL; ?>admin/view-receipt.php?ref_id=<?php echo $id; ?>"><img
                                src="../images/icons/receipt.png" width="35" /></a>
                    </td>
                </tr>
                <?php
            }
        } else {
            //Order not Available
            echo "<tr><td colspan='12' class='error'>No Orders Records Found!</td></tr>";
        }
        ?>


    </table>

</div>




<?php include ('partials/footer.php'); ?>