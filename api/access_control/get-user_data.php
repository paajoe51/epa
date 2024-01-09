<?php

// Assuming you have started the session
session_start();

// Check if the user is logged in
if(isset($_SESSION['SESS_MEMBER_ID'])) {

    // Include your database connection file
    include '../conn.php';

    // Escape the user ID to prevent SQL injection
    $userId = $_SESSION['SESS_MEMBER_ID'];

    // Query to get user data using PDO
    $query = "SELECT * FROM users WHERE id = :userId";
    
    // Prepare the SQL statement
    $statement = $db->prepare($query);
    
    // Bind the parameter
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    
    // Execute the query
    $statement->execute();

    // Fetch the data
    $userData = $statement->fetch(PDO::FETCH_ASSOC);

    if($userData) {
        // Convert the data to JSON
        $jsonData = json_encode($userData);

        // Return the JSON data
        echo $jsonData;
    } else {
        // Handle the case when no user is found
        echo "User not found";
    }

    // Close the database connection (optional for PDO)
    $db = null;
} else {
    // Handle the case when the user is not logged in
    echo "User not logged in";
}
?>
