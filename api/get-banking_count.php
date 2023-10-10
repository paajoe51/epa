<?php
include('conn.php');
session_start();
$branch = $_SESSION['SESS_BRANCH'] ;
$position = $_SESSION['SESS_POSITION'] ;

if($position=='branch_admin' | $position=='counselor' ){
    // Query to select data from the students table
$with_sql = "SELECT SUM(amount) as withdrawal_sum FROM banking WHERE branch='$branch' AND banking_type = 'withdrawal' ";
$hq_sql = "SELECT SUM(amount) as hq_sum FROM banking WHERE branch='$branch' AND banking_type='deposit' AND target = 'HQ'";
$epa_sql = "SELECT SUM(amount) as epa_sum FROM banking WHERE branch='$branch' AND banking_type='Deposit' AND target = 'EPADAC'";
}
else{
   // Query to select data from the students table
$with_sql = "SELECT SUM(amount) as withdrawal_sum FROM banking WHERE banking_type = 'withdrawal' ";
$hq_sql = "SELECT SUM(amount) as hq_sum FROM banking WHERE banking_type='deposit' AND target = 'HQ'";
$epa_sql = "SELECT SUM(amount) as epa_sum FROM banking WHERE banking_type='Deposit' AND target = 'EPADAC'";
}
// 


try {
    // Total students
    $with_stmt = $db->prepare($with_sql);
    $with_stmt->execute();
    $with_result = $with_stmt->fetch(PDO::FETCH_ASSOC);
    $withdrawals =  $with_result['withdrawal_sum'];

    // Male students
    $hq_stmt = $db->prepare($hq_sql);
    $hq_stmt->execute();
    $hq_result = $hq_stmt->fetch(PDO::FETCH_ASSOC);
    $hq =  $hq_result['hq_sum'];

    // Female students
    $epa_stmt = $db->prepare($epa_sql);
    $epa_stmt->execute();
    $epa_result = $epa_stmt->fetch(PDO::FETCH_ASSOC);
    $epa =  $epa_result['epa_sum'];

    
    

    // Store the counts in an associative array
    $data = [
        "withdrawals" => $withdrawals,
        "hq" => $hq,
        "epadac" => $epa
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
