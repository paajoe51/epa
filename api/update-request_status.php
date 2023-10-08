<?php
// update_status.php

include('conn.php');

// Get data from the POST request
$requestId = $_POST['requestId'];
$status = $_POST['status'];

// Update the status in the database
$sql = "UPDATE requests SET status = :status,type = 'earlier' WHERE id = :id";

try {
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $requestId);
    $stmt->execute();

    // Return a success response
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    // Return an error response
    echo json_encode(['success' => false, 'message' => 'Error updating status']);
}
?>
