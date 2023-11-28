<?php
include('conn.php');
session_start();
$position = $_SESSION['SESS_POSITION'] ;
$today=date("d/m/Y");

if($position=='branch_admin' | $position=='counselor' ){
    $branch = $_SESSION['SESS_BRANCH'] ;
    // Query to select data from the students table
    $fees_sql = "SELECT SUM(amount) as fee_sum FROM fees WHERE branch = '$branch'";
    $full_sql = "SELECT *  FROM students WHERE payment_status='Fully Paid' AND branch = '$branch'";
    $td_fee_sql = "SELECT SUM(amount) as day_fee_sum  FROM fees WHERE branch='$branch' AND date = '$today'";
    $st_sql = "SELECT *  FROM students WHERE branch = '$branch'";
}elseif (!empty($_SESSION['SESS_BRANCH_OVRD']) && $_SESSION['SESS_BRANCH_OVRD'] == true && $_SESSION['SESS_BRANCH']!='all') {
    // Query to select data from the students table
    $branch = $_SESSION['SESS_BRANCH'] ;
    $fees_sql = "SELECT SUM(amount) as fee_sum FROM fees WHERE branch = '$branch'";
    $full_sql = "SELECT *  FROM students WHERE payment_status='Fully Paid' AND branch = '$branch'";
    $td_fee_sql = "SELECT SUM(amount) as day_fee_sum  FROM fees WHERE branch='$branch' AND date = '$today'";
    $st_sql = "SELECT *  FROM students WHERE branch = '$branch'";
}else {
   // Query to select data from the students table
   $fees_sql = "SELECT SUM(amount) as fee_sum FROM fees";
   $full_sql = "SELECT *  FROM students WHERE payment_status='Fully Paid'";
   $td_fee_sql = "SELECT SUM(amount) as day_fee_sum  FROM fees WHERE  date = '$today'";
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

    // todays fee Paid
    $td_fee_stmt = $db->prepare($td_fee_sql);
    $td_fee_stmt->execute();
    $today_fees = $td_fee_stmt->fetch(PDO::FETCH_ASSOC);
    if ($today_fees['day_fee_sum']==null)
        $td_fee=0.00;
    else
        $td_fee =  $today_fees['day_fee_sum'];

    // Female students
    $st_stmt = $db->prepare($st_sql);
    $st_stmt->execute();
    $all_std = $st_stmt->rowCount();
    
    $partial = $all_std-$full;

    // Store the counts in an associative array
    $data = [
        "fees" => $fees,
        "full_fees" => $full,
        "today_fees" => $td_fee,
        "partial_fees" => $partial,
        "today" => $today
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
