<?php
include('../conn.php'); // Include your database connection file

// Check if the student_id is set and not empty
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $userId = $_POST['id'];

    // Your delete query, replace 'students' with your actual table name
    $sql = "DELETE FROM users WHERE id = :userId";

    try {
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $success = $stmt->execute(); // Store the result in a variable

        if ($success) {
            echo 'User deleted successfully';
        } else {
            echo 'Error deleting User';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Invalid User ID';
}
?>
