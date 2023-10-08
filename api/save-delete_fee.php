<?php
include('conn.php');
// Check if the student_id is set and not empty
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $feeId = $_POST['id'];

    // Your delete query, replace 'students' with your actual table name
    $sql = "DELETE FROM fees_table WHERE id = :feeId";

    try {
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':feeId', $feeId, PDO::PARAM_INT);
        $stmt->execute();
if($stmt)
        echo 'Course Deleted Successfully';
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Invalid student ID';
}
?>
