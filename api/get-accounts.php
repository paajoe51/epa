<?php
include('conn.php');
session_start();
//$branch = $_SESSION['SESS_BRANCH'] ;
$position = $_SESSION['SESS_POSITION'] ;
// Get the current month
$currentMonth = date('m');


if($position=='branch_admin' | $position=='counselor' ){
    $branch = $_SESSION['SESS_BRANCH'] ;
    // Query to select data from the students table
    $with_sql = "SELECT SUM(amount) as withdrawal_sum FROM banking WHERE branch='$branch' AND banking_type = 'withdrawal' ";
    $dep_sql = "SELECT SUM(amount) as deposit_sum FROM banking WHERE branch='$branch' AND banking_type = 'Deposit' ";
    $acc_reqs_sql = "SELECT SUM(amount) as apv_reqs_amt FROM requests WHERE branch='$branch' AND status = 'accepted' ";
    $hq_sql = "SELECT SUM(amount) as hq_sum FROM banking WHERE branch='$branch' AND banking_type='deposit' AND target = 'HQ'";
    $epa_sql = "SELECT SUM(amount) as epa_sum FROM banking WHERE branch='$branch' AND banking_type='Deposit' AND target = 'EPADAC'";
    $fees_sql = "SELECT SUM(amount) as fee_sum FROM fees WHERE branch='$branch'";
    $fees_cur_month_sql = "SELECT SUM(amount) as fees_cur_month FROM fees WHERE branch='$branch' AND MONTH(STR_TO_DATE(date, '%d/%m/%Y')) = :currentMonth ";
}elseif (!empty($_SESSION['SESS_BRANCH_OVRD']) && $_SESSION['SESS_BRANCH_OVRD'] == true && $_SESSION['SESS_BRANCH']!='all') {
    $branch = $_SESSION['SESS_BRANCH'] ;

    $with_sql = "SELECT SUM(amount) as withdrawal_sum FROM banking WHERE branch='$branch' AND banking_type = 'withdrawal' ";
    $dep_sql = "SELECT SUM(amount) as deposit_sum FROM banking WHERE branch='$branch' AND banking_type = 'Deposit' ";
    $acc_reqs_sql = "SELECT SUM(amount) as apv_reqs_amt FROM requests WHERE branch='$branch' AND status = 'accepted' ";
    $hq_sql = "SELECT SUM(amount) as hq_sum FROM banking WHERE branch='$branch' AND banking_type='deposit' AND target = 'HQ'";
    $epa_sql = "SELECT SUM(amount) as epa_sum FROM banking WHERE branch='$branch' AND banking_type='Deposit' AND target = 'EPADAC'";
    $fees_sql = "SELECT SUM(amount) as fee_sum FROM fees WHERE branch='$branch'";
    $fees_cur_month_sql = "SELECT SUM(amount) as fees_cur_month FROM fees WHERE branch='$branch' AND MONTH(STR_TO_DATE(date, '%d/%m/%Y')) = :currentMonth ";
}else {
    $with_sql = "SELECT SUM(amount) as withdrawal_sum FROM banking WHERE banking_type = 'withdrawal' ";
    $dep_sql = "SELECT SUM(amount) as deposit_sum FROM banking WHERE banking_type = 'Deposit' ";
    $acc_reqs_sql = "SELECT SUM(amount) as apv_reqs_amt FROM requests WHERE status = 'accepted' ";
    $hq_sql = "SELECT SUM(amount) as hq_sum FROM banking WHERE banking_type='deposit' AND target = 'HQ'";
    $epa_sql = "SELECT SUM(amount) as epa_sum FROM banking WHERE banking_type='Deposit' AND target = 'EPADAC'";
    $fees_sql = "SELECT SUM(amount) as fee_sum FROM fees";
    $fees_cur_month_sql = "SELECT SUM(amount) as fees_cur_month FROM fees WHERE MONTH(STR_TO_DATE(date, '%d/%m/%Y')) = :currentMonth ";
}

try {
    // Total Withdrawals
    $with_stmt = $db->prepare($with_sql);
    $with_stmt->execute();
    $with_result = $with_stmt->fetch(PDO::FETCH_ASSOC);
    $withdrawals =  $with_result['withdrawal_sum'];

    // Total Deposits
    $dep_stmt = $db->prepare($dep_sql);
    $dep_stmt->execute();
    $dep_result = $dep_stmt->fetch(PDO::FETCH_ASSOC);
    $deposits =  $dep_result['deposit_sum'];

    // Total Deposits
    $acc_reqs_stmt = $db->prepare($acc_reqs_sql);
    $acc_reqs_stmt->execute();
    $acc_reqs_result = $acc_reqs_stmt->fetch(PDO::FETCH_ASSOC);
    $acc_reqs_amt =  $acc_reqs_result['apv_reqs_amt'];

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

    // Fees Collected 
    $fees_stmt = $db->prepare($fees_sql);
    $fees_stmt->execute();
    $fees_result = $fees_stmt->fetch(PDO::FETCH_ASSOC);
    $fees =  $fees_result['fee_sum'];

    // Fees Collected 
    $fees_cur_month_stmt = $db->prepare($fees_cur_month_sql);
    // Bind parameters
    $fees_cur_month_stmt->bindParam(':currentMonth', $currentMonth, PDO::PARAM_INT);
    $fees_cur_month_stmt->execute();
    $fees_cur_month_result = $fees_cur_month_stmt->fetch(PDO::FETCH_ASSOC);
    $fees_cur_month_amt =  $fees_cur_month_result['fees_cur_month'];
        
    if ($withdrawals == null){
        $withdrawals =0;
    }
    if ( $deposits == null){
        $deposits =0;
    }
    if ($hq == null){
        $hq =0;
    }
    if ($epa == null){
        $epa =0;
    }
    if ($fees == null){
        $fees =0;
    }

    // Store the counts in an associative array
    $data = [
        "withdrawals" => $withdrawals,
        "deposits"=> $deposits,
        "acceped_requests"=> $acc_reqs_amt,
        "fees" => $fees,
        "fees_cur_month" => $fees_cur_month_amt,
        "hq" => $hq,
        "epadac" => $epa,
        "balance" => ($fees -  ($acc_reqs_amt+$deposits))
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
