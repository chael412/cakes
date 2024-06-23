<?php
// Database connection
include ('partials-front/menu.php');

if (isset($_POST['cancel_order'])) {
    $orderId = $_POST['orderId'];

    $query = "UPDATE tbl_order SET status = 'Cancelled' WHERE id = '$orderId'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        ?>
        <script>
            alert("Order was cancelled!")
            window.location.href = 'myorders.php'; 
        </script>
        <?php
    } else {
        echo "errrr: cancellation";
    }

}
