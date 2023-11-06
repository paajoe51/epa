<?php
// Check if the required POST fields are set
include('conn.php');

// Assuming these variables are posted from your form
$id = $_POST['id'];
$student_id = $_POST['student_id'];
$course = $_POST['course'];
$batch = $_POST['batch'];
$name = $_POST['name'];
$hometown = $_POST['hometown'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$sex = $_POST['sex'];
$duration = $_POST['duration'];

if (isset($student_id, $name, $sex)) {
    // Use prepared statements for the UPDATE query
    $sql = "UPDATE students 
            SET 
                course_duration = :duration, 
                batch = :batch, 
                name = :name, 
                hometown = :hometown, 
                contact = :contact, 
                email = :email, 
                sex = :sex 
            WHERE id = :id";

    $q = $db->prepare($sql);
    $q->bindParam(':id', $id);
    $q->bindParam(':batch', $batch);
    $q->bindParam(':name', $name);
    $q->bindParam(':hometown', $hometown);
    $q->bindParam(':contact', $contact);
    $q->bindParam(':email', $email);
    $q->bindParam(':sex', $sex);
    $q->bindParam(':duration', $duration);

    if ($q->execute()) {
        echo 200;
    } else {
        echo "Error updating student record.";
    }
} else {
    echo "Missing required fields.";
}
?>
