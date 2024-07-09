<?php 
require 'db_connection.php';

// Get the raw POST data
$postData = file_get_contents('php://input');
$request = json_decode($postData, true);

if (!isset($request['id'])) {
    die(json_encode(['error' => 'Product ID is not specified']));
}

$productID = $request['id'];

// Prepare and execute the select query to get the current like count
$query = "SELECT Product_Like FROM product WHERE product_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $productID);
$stmt->execute();

$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $likeCount = $row['Product_Like'] + 1;

    // Prepare and execute the update query to increment the like count
    $updateQuery = "UPDATE product SET Product_Like = ? WHERE product_id = ?";
    $updateStmt = $connection->prepare($updateQuery);
    $updateStmt->bind_param("ii", $likeCount, $productID);
    $updateStmt->execute();

    // Close the statements
    $stmt->close();
    $updateStmt->close();
    $connection->close();

    // Return the updated like count
    $response = ['likeCount' => $likeCount];
    echo json_encode($response);
} else {
    $stmt->close();
    $connection->close();
    die(json_encode(['error' => 'Product not found']));
}
?>
