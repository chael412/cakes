<?php include ('partials-front/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1 class="text-center">Order Details</h1>

        <br /><br /><br />
        <br><br>
        <center>
            <table class="content-table">
                <tr>
                    <th>S.N. </th>
                    <th>Cake </th>
                    <th>Price </th>
                    <th>Qty. </th>
                    <th>Total </th>
                    <th>Order Date </th>
                    <th>Status </th>
                    <th>Action</th>
                </tr>
                <hr>
                <?php
                //Get all the orders from database
                $sql = "SELECT * FROM tbl_order WHERE u_id={$_SESSION['u_id']} ORDER BY id DESC"; // DIsplay the Latest Order at First
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
                        $cake = $row['cake'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $total = $row['total'];
                        $order_date = $row['order_date'];
                        $status = $row['status'];

                        ?>

                        <tr>
                            <td><?php echo $sn++; ?>. </td>
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
                            <td>
                                <?php
                                if ($status == "Ordered") {
                                    ?>
                                    <form method="POST" action="code.php">
                                        <input type="hidden" name="orderId" value="<?= $id ?>">
                                        <button type="submit" name="cancel_order">cancel</button>
                                    </form>
                                    <?php
                                } else {
                                    echo '';
                                }
                                ?>
                            </td>
                        </tr>

                        <?php

                    }
                } else {
                    //Order not Available
                    echo "<tr><td colspan='12' class='error'>You have not placed any orders yet!!!</td></tr>";
                }
                ?>


            </table>
        </center>
    </div>

</div>

<?php include ('partials-front/footer.php'); ?>