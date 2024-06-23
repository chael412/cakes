<?php
include ('config/constants.php');

if (isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    // Check the stock for the requested cake
    $sql_stock = "SELECT tbl_cake.quantity FROM tbl_cart 
                  INNER JOIN tbl_cake ON tbl_cart.cake_id = tbl_cake.id 
                  WHERE tbl_cart.id = $cart_id";
    $res_stock = mysqli_query($conn, $sql_stock);
    $row_stock = mysqli_fetch_assoc($res_stock);

    if ($row_stock['quantity'] < $quantity) {
        echo json_encode(['status' => 'error', 'message' => 'Requested quantity exceeds available stock. Available stock: ' . $row_stock['quantity']]);
        exit();
    }

    // Update the quantity in the cart
    $sql = "UPDATE tbl_cart SET qty = $quantity WHERE id = $cart_id";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        // Fetch the updated cart details
        $sql2 = "SELECT tbl_cart.qty, tbl_cake.price FROM tbl_cart 
                 INNER JOIN tbl_cake ON tbl_cart.cake_id = tbl_cake.id 
                 WHERE tbl_cart.u_id = (SELECT u_id FROM tbl_cart WHERE id = $cart_id)";
        $res2 = mysqli_query($conn, $sql2);

        $total = 0;
        $subtotal = 0;
        while ($row = mysqli_fetch_assoc($res2)) {
            if ($row['qty'] == $quantity) {
                $subtotal = $row['price'] * $row['qty'];
            }
            $total += $row['price'] * $row['qty'];
        }

        echo json_encode(['status' => 'success', 'subtotal' => $subtotal, 'total' => $total]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update cart.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
