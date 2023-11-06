<?php
// Check if the batchId and status are set in the POST request
if (isset($_POST['batchId'], $_POST['status'])) {
    $batchId = $_POST['batchId'];
    $status = $_POST['status'];
    include('conn.php');

    try {
        // Replace with your database connection logic
 
        // Update the 'status' column in the 'batches' table
        $updateSql = "UPDATE batches SET status = :status WHERE id = :batchId";
        $updateStmt = $db->prepare($updateSql);
        $updateStmt->bindParam(':status', $status, PDO::PARAM_STR);
        $updateStmt->bindParam(':batchId', $batchId, PDO::PARAM_INT);
        $updateStmt->execute();

        echo "Update successful";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request parameters";
}
?>
