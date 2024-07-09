<?php 
session_start();
require 'db_connection.php';

if (!isset($_SESSION['id'])) {
    die(json_encode(['error' => 'User is not logged in']));
}

$customerID = $_SESSION['id'];

// Get the raw POST data
$postData = file_get_contents('php://input');
$request = json_decode($postData, true);

if (!isset($request['id'])) {
    die(json_encode(['error' => 'Product ID is not specified']));
}

$productID = $request['id'];

// Prepare and execute the select query
$query = "SELECT Customer_Cart FROM Customer WHERE Customer_ID = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$customerCart = $row['Customer_Cart'];

// Check if customerCart has []
if (empty($customerCart)) {
    $customerCart = "[]";
}

$customerCartArray = json_decode($customerCart, true);
if ($customerCartArray === null) {
    $customerCartArray = [];
}

if (!in_array($productID, $customerCartArray)) {
    $customerCartArray[] = $productID;
    $customerCart = json_encode($customerCartArray);
    
    // Prepare and execute the update query
    $updateQuery = "UPDATE Customer SET Customer_Cart = ? WHERE Customer_ID = ?";
    $updateStmt = $connection->prepare($updateQuery);
    $updateStmt->bind_param("si", $customerCart, $customerID);
    $updateStmt->execute();
}

$stmt->close();
$updateStmt->close();
$connection->close();

// Return the updated cart count
$response = [
    'cartCount' => count($customerCartArray)
];
echo json_encode($response);
?>
