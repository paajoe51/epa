<?php
// Include your database connection file
include('conn.php');

// Get data from the client
$request_amount = $_POST['request_amount'];
$request_date = $_POST['request_date'];
$request_note = $_POST['request_note'];
$request_branch = $_POST['request_branch'];
$request_personnel = $_POST['request_personnel'];

if ($request_amount == "" || $request_note == "") {
    $response = 201;
} else {
    // Prepare the SQL query with placeholders
    $sql = "INSERT INTO requests ( amount, date, description, status, branch, personnel, type) VALUES (:request_amount, :request_date, :request_note, 'pending', '$request_branch', '$request_personnel', 'recent')";

    try {
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':request_amount', $request_amount);
        $stmt->bindParam(':request_date', $request_date);
        $stmt->bindParam(':request_note', $request_note);

        if ($stmt->execute()) {
            // Send email
            $to = 'paajoe51@yahoo.com'; //
            $subject = 'EPADAC IPMC - New Expenditure  Request';
            $message = "Amount: $request_amount\nNote: $request_note\nBranch: $request_branch";

            
            // Additional headers
            $headers = 'From: webmaster@example.com' . "\r\n" .
                'Reply-To: webmaster@example.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            // Send email
            mail($to, $subject, $message, $headers);

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
