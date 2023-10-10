<?php
// Include your database connection file
include('conn.php');

// Get data from the client
$banking_date = $_POST['banking_date'];
$branch_name = $_POST['branch_name'];
$banking_type = $_POST['banking_type'];
$inv_id = $_POST['inv_id'];
$target = $_POST['target'];
$amount = $_POST['amount'];
$comment = $_POST['comment'];

// Check if amount or inv_id is empty
if ($amount == "" || $inv_id == "") {
    echo 201; // Code for empty fields
} else {
    // Prepare the SQL query with placeholders
    $sql = "INSERT INTO banking (date, branch, banking_type, inv_id, target, amount, comment) 
            VALUES (:banking_date, :branch_name, :banking_type, :inv_id, :target, :amount, :comment)";

    try {
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':banking_date', $banking_date);
        $stmt->bindParam(':branch_name', $branch_name);
        $stmt->bindParam(':banking_type', $banking_type);
        $stmt->bindParam(':inv_id', $inv_id);
        $stmt->bindParam(':target', $target);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':comment', $comment);

        if ($stmt->execute()) {
            echo 200; // Code for success
        } else {
            echo 500; // Code for database error
        }
    } catch (PDOException $e) {
        echo 500; // Code for database error
    }
}
?>
