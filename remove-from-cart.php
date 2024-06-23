<?php
include('config/constants.php');

// Check if the user is logged in
if(!isset($_SESSION['u_id'])) {
    header('location:login.php');
    exit();
}

// Check if cart_id is set
if(isset($_GET['cart_id'])) {
    $cart_id = $_GET['cart_id'];
    $u_id = $_SESSION['u_id'];

    // Delete the item from the cart
    $sql = "DELETE FROM tbl_cart WHERE id=$cart_id AND u_id=$u_id";
    $res = mysqli_query($conn, $sql);

    // Check whether the query executed successfully
    if($res == true) {
        // Item removed successfully
        $_SESSION['cart'] = "<div class='success'>Item removed successfully.</div>";
    } else {
        // Failed to remove item
        $_SESSION['cart'] = "<div class='error'>Failed to remove item. Try again later.</div>";
    }
    header('location:cart.php');
} else {
    // Redirect to cart page if cart_id is not set
    header('location:cart.php');
}
?>
