<?php include ('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <?php
        // Check whether id is set or not
        if (isset($_GET['id'])) {
            // Get the Order Details
            $id = $_GET['id'];
            // Display user details
            $user_query = "SELECT tbl_order.id AS order_id, users.*, tbl_order.*, rf.ref_no as rf_no FROM users 
                INNER JOIN tbl_order ON users.id=tbl_order.u_id
                INNER JOIN ref_no rf ON tbl_order.ref_no = rf.ref_id
                WHERE rf.ref_id = $id LIMIT 1";
            $user_res = mysqli_query($conn, $user_query);
            if (mysqli_num_rows($user_res) > 0) {
                while ($user = mysqli_fetch_assoc($user_res)) {
                    ?>
                    <h1>View Orders</h1>
                    <div>
                        <span>Reference#: <?= $user['rf_no'] ?></span><br>
                        <span>Date Ordered: <?= date("F j, Y", strtotime($user['order_date'])); ?></span><br>
                        <span><span>Customer Name:</span> <?= $user['username'] ?></span> <br>
                        <span>Customer Address: <?= $user['customer_address'] ?></span><br>
                    </div>
                    <br>
                    <?php
                }
            }
            ?>
            <?php
            $sql = "SELECT tbl_order.id AS order_id, users.*, tbl_order.*, rf.ref_no as rf_no FROM users 
            INNER JOIN tbl_order ON users.id=tbl_order.u_id
            INNER JOIN ref_no rf ON tbl_order.ref_no = rf.ref_id
            WHERE rf.ref_id = $id";

            // Execute Query
            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res) > 0) {
                ?>
                <form action="update-order.php" method="POST">
                    <table class="tbl-full">
                        <tr>
                            <th>Select</th>
                            <th>#</th>
                            <th>Cake</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>

                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($res)) {
                            ?>
                            <tr>
                                <td><input type="checkbox" name="order_ids[]" value="<?= $row['order_id']; ?>" checked></td>
                                <td><?= $i++ ?></td>
                                <td><?= $row['cake']; ?></td>
                                <td><?= $row['price']; ?></td>
                                <td><?= $row['qty']; ?></td>
                                <td><?= $row['total']; ?></td>
                                <td><?= $row['status']; ?></td>
                            </tr>
                            <?php
                        } ?>
                    </table>
                    <br>
                    <label for="status">New Status:</label>
                    <select name="status" required>
                        <option value="Ordered">Ordered</option>
                        <option value="On Delivery">On Delivery</option>
                        <option value="Delivered">Delivered</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                    <input type="submit" name="submit" value="Update Orders" class="btn-secondary">
                </form>
                <?php
            } else {
                echo '<div class="error">No orders found.</div>';
            }
        } else {
            echo '<div class="error">Invalid ID.</div>';
        }

        mysqli_close($conn);
        ?>
    </div>
</div>

<?php include ('partials/footer.php'); ?>