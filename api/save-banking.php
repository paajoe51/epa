<?php

// Include your database connection file
include('conn.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["inv_id"]) || empty($_POST["amount"])){
        echo 201;
    }

    else{
    // Get form data
    $banking_date = $_POST["banking_date"];
    $branch_name = $_POST["branch_name"];
    $banking_type = $_POST["banking_type"];
    $inv_id = $_POST["inv_id"];
    $target = $_POST["target"];
    $amount = $_POST["amount"];
    $comment = $_POST["comment"];

    try {
        // Prepare the SQL query
        $query = $db->prepare("INSERT INTO banking (date, branch, banking_type, inv_id, target, amount, comment)
                                VALUES (:banking_date, :branch_name, :banking_type, :inv_id, :target, :amount, :comment)");

        // Bind parameters
        $query->bindParam(':banking_date', $banking_date);
        $query->bindParam(':branch_name', $branch_name);
        $query->bindParam(':banking_type', $banking_type);
        $query->bindParam(':inv_id', $inv_id);
        $query->bindParam(':target', $target);
        $query->bindParam(':amount', $amount);
        $query->bindParam(':comment', $comment);

        // Execute the query
        $query->execute();
        $number = ['233248394057', '233542399543','233547553885'];    
        $message = "Banking Transaction \nTransaction Type: $banking_type \nAn amount of GHC $amount has been banked into $target Account from $branch_name Branch. \nInvoice ID :  $inv_id";
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
