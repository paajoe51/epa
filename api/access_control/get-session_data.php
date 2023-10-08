<?php
session_start();
include('../conn.php');

// Check if the user is logged in
if (isset($_SESSION['SESS_MEMBER_ID'])) {
    $s_id = $_SESSION['SESS_MEMBER_ID'];

    // Query to select data from the users table
    $sql = "SELECT * FROM users
            WHERE id=$s_id";

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();

        // Fetch data and store it in an array
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Encode the data as JSON
        $json_data = json_encode($data);

        // Output the JSON data
        header('Content-Type: application/json');
        echo $json_data;
    } catch (PDOException $e) {
        // Handle query error
        echo "Error: " . $e->getMessage();
    }
} else {
    // If the user is not logged in, return an empty JSON object
    echo json_encode(array());
}
?>
