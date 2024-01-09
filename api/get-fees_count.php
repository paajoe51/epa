<?php
include('conn.php');
session_start();
$position = $_SESSION['SESS_POSITION'] ;
$today=date("d/m/Y");
$currentYear = date("Y");

if($position=='branch_admin' || $position=='counselor' ){
    $branch = $_SESSION['SESS_BRANCH'] ;
    // Query to select data from the students table
    $fees_sql = "SELECT SUM(amount) as fee_sum FROM fees WHERE branch = '$branch' AND YEAR(STR_TO_DATE(date, '%d/%m/%Y')) = $currentYear";
    $reg_fees_sql = "SELECT SUM(amount) as reg_fee_sum FROM fees WHERE branch = '$branch' AND YEAR(STR_TO_DATE(date, '%d/%m/%Y')) = $currentYear";
    $full_sql = "SELECT *  FROM students WHERE payment_status='Fully Paid' AND branch = '$branch' AND YEAR(STR_TO_DATE(date, '%d/%m/%Y')) = $currentYear";
    $full_amt_sql = "SELECT  SUM(amount_paid)  as full_amt  FROM students WHERE payment_status='Fully Paid' AND branch = '$branch' AND YEAR(STR_TO_DATE(date, '%d/%m/%Y')) = $currentYear";
    $owing_fee_sql = "SELECT SUM(payment_status) as owing_fee_sum  FROM students WHERE branch='$branch' AND YEAR(STR_TO_DATE(date, '%d/%m/%Y')) = $currentYear AND payment_status < 0";
    $st_sql = "SELECT *  FROM students WHERE branch = '$branch'";
}elseif (!empty($_SESSION['SESS_BRANCH_OVRD']) && $_SESSION['SESS_BRANCH_OVRD'] == true && $_SESSION['SESS_BRANCH']!='all') {
    // Query to select data from the students table
    $branch = $_SESSION['SESS_BRANCH'] ;
    $fees_sql = "SELECT SUM(amount) as fee_sum FROM fees WHERE branch = '$branch' AND fee_type != 'Registration'";
    $reg_fees_sql = "SELECT SUM(amount) as reg_fee_sum FROM fees WHERE branch = '$branch' AND fee_type = 'Registration'";
    $full_sql = "SELECT *  FROM students WHERE payment_status='Fully Paid' AND branch = '$branch'";
    $full_amt_sql = "SELECT  SUM(amount_paid) as full_amt FROM students WHERE payment_status='Fully Paid' AND branch = '$branch'";
    $owing_fee_sql = "SELECT SUM(payment_status) as owing_fee_sum  FROM students WHERE branch='$branch' AND payment_status < 0";
    $st_sql = "SELECT *  FROM students WHERE branch = '$branch'";
}else {
   // Query to select data from the students table
   $fees_sql = "SELECT SUM(amount) as fee_sum FROM fees WHERE fee_type != 'Registration'";
   $reg_fees_sql = "SELECT SUM(amount) as reg_fee_sum FROM fees WHERE fee_type = 'Registration'";
   $full_sql = "SELECT *  FROM students WHERE payment_status='Fully Paid'";
   $full_amt_sql = "SELECT  SUM(amount_paid) as full_amt FROM students WHERE payment_status='Fully Paid'";
   $owing_fee_sql = "SELECT SUM(payment_status) as owing_fee_sum  FROM students WHERE payment_status < 0";
   $st_sql = "SELECT *  FROM students";
}


try {
    // Total Fees
    $fees_stmt = $db->prepare($fees_sql);
    $fees_stmt->execute();
    $fees_result = $fees_stmt->fetch(PDO::FETCH_ASSOC);
    $fees =  $fees_result['fee_sum'];

     // Registration  Fees
     $reg_fees_stmt = $db->prepare($reg_fees_sql);
     $reg_fees_stmt->execute();
     $reg_fees_result = $reg_fees_stmt->fetch(PDO::FETCH_ASSOC);
     $reg_fees_amt =  $reg_fees_result['reg_fee_sum'];

    // Fully Paid Number
    $full_stmt = $db->prepare($full_sql);
    $full_stmt->execute();
    $full = $full_stmt->rowCount();

        // todays fee Paid
    $full_amt_stmt = $db->prepare($full_amt_sql);
    $full_amt_stmt->execute();
    $full_amt = $full_amt_stmt->fetch(PDO::FETCH_ASSOC);
    if ($full_amt['full_amt']==null)
        $full_amt=0.00;
    else
        $full_amt =  $full_amt['full_amt'];

    // todays fee Paid
    $owing_fee_stmt = $db->prepare($owing_fee_sql);
    $owing_fee_stmt->execute();
    $owing_fees = $owing_fee_stmt->fetch(PDO::FETCH_ASSOC);
    if ($owing_fees['owing_fee_sum']==null)
        $owing_fees=0.00;
    else
        $owing_fees =  $owing_fees['owing_fee_sum'];

    // Female students
    $st_stmt = $db->prepare($st_sql);
    $st_stmt->execute();
    $all_std = $st_stmt->rowCount();
    
    $partial = $all_std-$full;
    $partial_amt = $fees-$full_amt;

    // Store the counts in an associative array
    $data = [
        "fees" => $fees,
        "full_fees" => $full,
        "registration_fee" => $reg_fees_amt,
        "full_fees_amt" => $full_amt,
        "owing_fees" => $owing_fees,
        "partial_fees" => $partial,
        "partial_fees_amt" => $partial_amt,
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
