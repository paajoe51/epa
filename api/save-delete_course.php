<?php
include('conn.php');
// Check if the student_id is set and not empty
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $courseId = $_POST['id'];

    // Your delete query, replace 'students' with your actual table name
    $sql = "DELETE FROM courses WHERE id = :courseId";

    try {
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
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
