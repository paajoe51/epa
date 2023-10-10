<?php
include('conn.php');
session_start();
$branch=$_SESSION['SESS_BRANCH']; 

// Query to select data from the courses table
$sql = "SELECT * FROM fees WHERE branch = '$branch'";

try {
    $stmt = $db->prepare($sql);
    $stmt->execute();

    // Fetch data and store it in an array
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Encode the data as JSON
    $json_data = json_encode($data);

    // Output the JSON data
    header('Content-Type: application/json');
    echo $json_data;
} catch (PDOException $e) {
    // Handle query error
    echo "Error: " . $e->getMessage();
}
?>