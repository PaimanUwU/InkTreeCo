<?php
require 'db_connection.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $query = "UPDATE customer
              SET customer_name = ?, customer_email = ?, customer_phone = ?, customer_address = ?
              WHERE customer_ID = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $phone, $address, $_SESSION['id']);   
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    $currentPage = $_GET['currentPage'];

    header("Location: ../page/" . $currentPage);
}
?>