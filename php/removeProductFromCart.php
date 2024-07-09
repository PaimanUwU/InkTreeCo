<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['id']) || !isset($_GET['index'])) {
    header("Location: ../page/cart.php");
    exit();
}

$customer_id = (int) $_SESSION['id']; // Sanitizing input
$product_index = (int) $_GET['index']; // Sanitizing input

$query = "SELECT * FROM customer WHERE customer_id = $customer_id";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $customerCart = $row['CUSTOMER_CART'];

    $customerCart = json_decode($customerCart, true);

    if (is_array($customerCart) && isset($customerCart[$product_index])) {
        // remove item from cart
        array_splice($customerCart, $product_index, 1);

        $customerCart = json_encode($customerCart);

        $updateQuery = "UPDATE customer SET customer_cart = '" . mysqli_real_escape_string($connection, $customerCart) . "' WHERE customer_id = $customer_id";
        $updateResult = mysqli_query($connection, $updateQuery);

        if (!$updateResult) {
            die('Error updating cart: ' . mysqli_error($connection));
        }
    }
}

mysqli_close($connection);

header("Location: ../page/cart.php");
exit();
?>
