<?php
include('conn.php'); // Include your database connection file

// Get data from the client
$id = $_POST['fee_id'];
$a = $_POST['course_name'];
$b = $_POST['duration'];
$c = $_POST['amount'];

// Prepare the SQL query with placeholders
$sql = "UPDATE fees_table SET amount = :c, duration = :b
               WHERE id = :id";
$q = $db->prepare($sql);
$q->execute(array(':b' => $b, ':c' => $c, ':id' => $id));

if ($q->rowCount() > 0) {
    $response = array('success' => true);
} else {
    $response = array('success' => false, 'message' => 'Failed to update the fee.');
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
