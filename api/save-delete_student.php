<?php
include('conn.php'); // Include your database connection file

// Check if the student_id is set and not empty
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $studentId = $_POST['id'];

    // Your delete query, replace 'students' with your actual table name
    $sql = "DELETE FROM students WHERE id = :studentId";

    try {
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
        $success = $stmt->execute(); // Store the result in a variable

        if ($success) {
            echo 'Student deleted successfully';
        } else {
            echo 'Error deleting student';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Invalid student ID';
}
?>
