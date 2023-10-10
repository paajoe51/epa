<?php
include('conn.php');
session_start();
$branch = $_SESSION['SESS_BRANCH'] ;
$position = $_SESSION['SESS_POSITION'] ;

if($position=='branch_admin' | $position=='counselor' ){
    // Query to select data from the students table
    $fees_sql = "SELECT SUM(amount_paid) as fee_sum FROM students WHERE branch = '$branch'";
    $full_sql = "SELECT *  FROM students WHERE payment_status='Fully Paid' AND branch = '$branch'";
    $st_sql = "SELECT *  FROM students WHERE branch = '$branch'";
}

else{
    // Query to select data from the students table
    $fees_sql = "SELECT SUM(amount_paid) as fee_sum FROM students";
    $full_sql = "SELECT *  FROM students WHERE payment_status='Fully Paid'";
    $st_sql = "SELECT *  FROM students";
}


try {
    // Total Fees
    $fees_stmt = $db->prepare($fees_sql);
    $fees_stmt->execute();
    $fees_result = $fees_stmt->fetch(PDO::FETCH_ASSOC);
    $fees =  $fees_result['fee_sum'];

    // Fully Paid
    $full_stmt = $db->prepare($full_sql);
    $full_stmt->execute();
    $full = $full_stmt->rowCount();

    // Female students
    $st_stmt = $db->prepare($st_sql);
    $st_stmt->execute();
    $all_std = $st_stmt->rowCount();
    
    $partial = $all_std-$full;

    // Store the counts in an associative array
    $data = [
        "fees" => $fees,
        "full_fees" => $full,
        "partial_fees" => $partial
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
