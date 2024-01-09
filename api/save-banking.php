<?php

// Include your database connection file
include('conn.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["epa_inv_id"]) || empty($_POST["epa_amount"]) || empty($_POST["epa_inv_id"]) || empty($_POST["epa_amount"])){
        echo 201;
    }

    else{
    // Get form data
    $banking_date = $_POST["banking_date"];
    $branch_name = $_POST["branch_name"];
    $banking_type = $_POST["banking_type"];
    $epa_id = $_POST["epa_inv_id"];
    $hq_id = $_POST["hq_inv_id"];
    $epa_target = "EPADAC";
    $hq_target = "HQ";
    $epa_amount = $_POST["epa_amount"];
    $hq_amount = $_POST["hq_amount"];
    $comment = $_POST["comment"];

    function formatMoney($amount) {
        // Format the amount as currency with two decimal places and commas as thousands separators
        return 'GHC ' . number_format($amount, 2, '.', ',');
    }
    
    $balance=formatMoney($epa_amount+$hq_amount);
    $epa =formatMoney( $epa_amount);
    $hq  =formatMoney($hq_amount);
    try {
        // Prepare the SQL query
        $query = $db->prepare("INSERT INTO banking (date, branch, banking_type, inv_id, target, amount, comment)
                                VALUES (:banking_date, :branch_name, :banking_type, :inv_id, :target, :amount, :comment)");

        // Bind parameters
        $query->bindParam(':banking_date', $banking_date);
        $query->bindParam(':branch_name', $branch_name);
        $query->bindParam(':banking_type', $banking_type);
        $query->bindParam(':inv_id', $epa_id);
        $query->bindParam(':target', $epa_target);
        $query->bindParam(':amount', $epa_amount);
        $query->bindParam(':comment', $comment);
        $query->execute();

        $query = $db->prepare("INSERT INTO banking (date, branch, banking_type, inv_id, target, amount, comment)
                                VALUES (:banking_date, :branch_name, :banking_type, :inv_id, :target, :amount, :comment)");
        // Bind parameters
        $query->bindParam(':banking_date', $banking_date);
        $query->bindParam(':branch_name', $branch_name);
        $query->bindParam(':banking_type', $banking_type);
        $query->bindParam(':inv_id', $hq_id);
        $query->bindParam(':target',  $hq_target);
        $query->bindParam(':amount', $hq_amount);
        $query->bindParam(':comment', $comment);

        // Execute the query
        $query->execute();
        $number = ['233248394057'];    
        $message = "Banking Transaction \n 
                    Balance Before : $balance \n
                    EPADAC  Banked Amount : $epa\n
                    HQ Banked Amount : $hq \n
                    Branch : $branch_name";
        include('send-sms.php');
        $response = array('success' => true);

        // If the query is successful, you can echo a success message or perform any other actions
        echo 200;
    } catch (PDOException $e) {
        // If there's an error, echo the error message
        echo "Error: " . $e->getMessage();
    }
  }
}
?>
