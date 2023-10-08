<?php
include('conn.php');
session_start();
$branch=$_SESSION['SESS_BRANCH'];

// Query to select data from the students table
$all_sql = "SELECT * FROM requests WHERE branch='$branch'";
$pen_sql = "SELECT * FROM requests WHERE branch='$branch' AND status = 'pending'";
$acc_sql = "SELECT * FROM requests WHERE branch='$branch' AND status = 'accepted'";
$rej_sql = "SELECT * FROM requests WHERE branch='$branch' AND status = 'rejected'";

try {
    // Total students
    $all_stmt = $db->prepare($all_sql);
    $all_stmt->execute();
    $total_request = $all_stmt->rowCount();

    // Male students
    $pen_stmt = $db->prepare($pen_sql);
    $pen_stmt->execute();
    $pending_requests = $pen_stmt->rowCount();

    // Female students
    $acc_stmt = $db->prepare($acc_sql);
    $acc_stmt->execute();
    $accepted_requests = $acc_stmt->rowCount();

    
    // Rejected students
    $rej_stmt = $db->prepare($acc_sql);
    $acc_stmt->execute();
    $rejected_requests = $acc_stmt->rowCount();

    // Store the counts in an associative array
    $data = [
        "total" => $total_request,
        "pending" => $pending_requests,
        "accepted" => $accepted_requests,
        "rejected" => $rejected_requests
    ];

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
