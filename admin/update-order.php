<?php include ('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order Status</h1>

        <?php
        if (isset($_POST['submit'])) {
            // Get order ids and new status from the form
            $order_ids = $_POST['order_ids'];
            $status = $_POST['status'];

            if (!empty($order_ids)) {
                // Prepare a string of order IDs for the SQL query
                $order_ids_str = implode(",", $order_ids);

                // Update order statuses
                $sql = "UPDATE tbl_order SET status='$status' WHERE id IN ($order_ids_str)";

                $res = mysqli_query($conn, $sql);

                if ($res == true) {
                    $_SESSION['update'] = "<div class='success'>Order Status Updated Successfully.</div>";
                } else {
                    $_SESSION['update'] = "<div class='error'>Failed to Update Order Status.</div>";
                }
            } else {
                $_SESSION['update'] = "<div class='error'>No orders selected.</div>";
            }
            header('location:' . SITEURL . 'admin/manage-order.php');
        } else {
            header('location:' . SITEURL . 'admin/manage-order.php');
        }
        ?>
    </div>
</div>

<?php include ('partials/footer.php'); ?>