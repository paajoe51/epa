<?php
// Include your database connection file
include('conn.php');

// Get data from the client
$amount = $_POST['amount'];
$student_name =  $_POST['st_name'];
$date = $_POST['date'];
$comment = $_POST['comment'];
$branch = $_POST['branch_name'];
$student = $_POST['fee_student'];
$trans_id = $_POST['trans_id'];
$sp_contact = $_POST['sp_contact'];
$course = str_replace("+", " ", ($_POST['course']));
$duration =  str_replace("+", " ", ($_POST['duration']));

if ($amount == "" || $student == "") {
    $response = 201;
} else {
    // Rest of your code
    try {
        // Fetch the current amount paid from the students table
        $query = "SELECT amount_paid FROM students WHERE id = :student_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':student_id', $student);
        $stmt->execute();
        $currentAmountPaid = $stmt->fetchColumn();
        // Calculate the new amount by adding the current amount and the new amount from the form
        $newAmount = $currentAmountPaid + $amount;

        // Fetch the current amount paid from the students table
        $fee_query = "SELECT amount FROM fees_table WHERE course_name = :course AND duration = :duration" ;
        $fee_stmt = $db->prepare($fee_query);
        $fee_stmt->bindParam(':course', $course);
        $fee_stmt->bindParam(':duration', $duration);
        $fee_stmt->execute();
        $fee = $fee_stmt->fetchColumn();

        // Calculate the new amount by adding the current amount and the new amount from the form
        if ($newAmount<$fee){
            $payment_status= $newAmount-$fee;
        }
        elseif ($newAmount>=$fee){
            $payment_status="Fully Paid";
        }

        // Update the amount_paid in the students table
        $updateQuery = "UPDATE students SET amount_paid = :new_amount, payment_status = :payment_status WHERE id = :student_id";
        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->bindParam(':new_amount', $newAmount);
        $updateStmt->bindParam(':payment_status', $payment_status);
        $updateStmt->bindParam(':student_id', $student);
        $updateStmt->execute();

        // Insert the new fee record
        $insertQuery = "INSERT INTO fees (date, transaction_id, branch, amount, comment, student_id) VALUES (:fee_date, :trans_id, :branch, :amount, :comment, :student_id)";
        $insertStmt = $db->prepare($insertQuery);
        $insertStmt->bindParam(':fee_date', $date);
        $insertStmt->bindParam(':branch', $branch);
        $insertStmt->bindParam(':amount', $amount);
        $insertStmt->bindParam(':comment', $comment);
        $insertStmt->bindParam(':student_id', $student);
        $insertStmt->bindParam(':trans_id', $trans_id);

        if ($insertStmt->execute()) {
            $number = ['233' . substr($sp_contact, 1)];    
            $message = "An amount of GHC $amount has been successfully paid as fees for $student_name. \nTotal Amount Paid is GHC $newAmount \nRemaining Balance is  $payment_status";
            include('send-sms.php');
            $response = array('success' => true);

        } else {
            $response = array('success' => false, 'message' => 'Failed to save request.');
        }
    } catch (PDOException $e) {
        $response = array('success' => false, 'message' => 'Database error.');
    }
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
