<?php
include('conn.php');
// Get the ID to be deleted from the POST data
$id = $_POST['id'];

// SQL to delete the record from the database
$sql = "DELETE FROM branches WHERE id = $id";

try {
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':branchId', $id, PDO::PARAM_INT);
    $stmt->execute();

    if($stmt)
    echo "success";
}catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

// Close the database connection
?>
