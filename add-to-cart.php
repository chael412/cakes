<?php
include ('config/constants.php');

// Check if user is logged in
if (!isset($_SESSION['u_id'])) {
    header('location:login.php');
    exit();
}

if (isset($_GET['cake_id'])) {
    $cake_id = $_GET['cake_id'];
    $u_id = $_SESSION['u_id'];
    



    // Check if the item already exists in the cart
    $sql = "SELECT * FROM tbl_cart WHERE cake_id=$cake_id AND u_id=$u_id";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if ($count > 0) {
        // Item exists, update quantity
        $row = mysqli_fetch_assoc($res);
        $qty = $row['qty'] + 1;

        $sql2 = "UPDATE tbl_cart SET qty=$qty WHERE cake_id=$cake_id AND u_id=$u_id";
        mysqli_query($conn, $sql2);
    } else {

        // Item doesn't exist, insert new record
        $sql2 = "INSERT INTO tbl_cart (cake_id, qty, u_id) VALUES ($cake_id, 1, $u_id)";
        mysqli_query($conn, $sql2);

    }

    header('location:cart.php');
} else {
    header('location:index.php');
}
?>