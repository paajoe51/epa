<?php
include('conn.php');

// Check if the required POST fields are set
if (isset($_POST['course'], $_POST['batch'], $_POST['name'], $_POST['branch'], $_POST['branch'], $_POST['dob'])) {
    $a = $_POST['student_id'];
    $b = $_POST['course'];
    $c = $_POST['batch'];
    $d = $_POST['name'];
    $e = $_POST['branch'];
    $f = $_POST['dob'];
    $g = $_POST['hometown'];
    $h = $_POST['contact'];
    $i = $_POST['email'];
    $j = $_POST['sex'];
    $k = $_POST['course_duration'];

    // Use prepared statements to prevent SQL injection
    $qry = $db->prepare("SELECT * FROM students WHERE student_id = :student_id AND contact= :contact" );
    $qry->bindParam(':student_id', $a);
    $qry->bindParam(':contact', $h);
    $qry->execute();
    $uCount = $qry->rowCount();

    if ($uCount > 0) {
        echo 400;
    } else {
        // Use prepared statements for the INSERT query
        $sql = "INSERT INTO students (student_id, course,course_duration, batch, name, branch, dob, hometown, contact, email, sex) 
                VALUES (:student_id, :course, :duration, :batch, :name, :branch, :dob, :hometown, :contact, :email, :sex)";

        $q = $db->prepare($sql);
        $q->bindParam(':student_id', $a);
        $q->bindParam(':course', $b);
        $q->bindParam(':batch', $c);
        $q->bindParam(':name', $d);
        $q->bindParam(':branch', $e);
        $q->bindParam(':dob', $f);
        $q->bindParam(':hometown', $g);
        $q->bindParam(':contact', $h);
        $q->bindParam(':email', $i);
        $q->bindParam(':sex', $j);
        $q->bindParam(':duration', $k);
        if ($q->execute()) {
            echo 200;
        } else {
            echo "Error inserting user.";
        }
    }
} else {
    echo "Missing required fields.";
}
?>
