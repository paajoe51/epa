<?php
// Assuming you have a database connection established
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the updated data from the AJAX request
    $branch_id = $_POST['branch_id'];
    $branch_name = $_POST['branch_name'];
    $branch_location = $_POST['branch_location'];
    // Add other fields here

    // Update the record in the database using PDO
    try {
        // Prepare the SQL query
        $query = "UPDATE branches SET name = :branch_name , location = :br_location WHERE id = :branch_id";
        $statement = $db->prepare($query);

        // Bind parameters
        $statement->bindParam(':branch_name', $branch_name, PDO::PARAM_STR);
        $statement->bindParam(':br_location', $branch_location, PDO::PARAM_STR);
        $statement->bindParam(':branch_id', $branch_id, PDO::PARAM_INT);

        // Execute the query
        $result = $statement->execute();

        if ($result) {
            echo 200;
        } else {
            echo 'Error updating record';
        }
    } catch (PDOException $e) {
        // Handle PDO exceptions
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Invalid request';
}
?>
