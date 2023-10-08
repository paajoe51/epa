<?php
// Check if the required POST fields are set
include('con.php');
$id = $_POST['sid'];
$a = $_POST['student_id'];
$b = $_POST['course'];
$c = $_POST['batch'];
$d = $_POST['name'];
$g = $_POST['hometown'];
$h = $_POST['contact'];
$i = $_POST['email'];
$j = $_POST['sex'];
$k = $_POST['duration'];

if (isset($_POST['student_id'], $_POST['course'],$_POST['name'], $_POST['branch'])) {


    // Use prepared statements for the UPDATE query
    $sql = "UPDATE students 
            SET course = :course, 
                course_duration = :duration, 
                batch = :batch, 
                name = :name, 
                hometown = :hometown, 
                contact = :contact, 
                email = :email, 
                sex = :sex 
            WHERE id = :id";

    $q = $db->prepare($sql);
         $q->bindParam(':id', $a);
         $q->bindParam(':course', $b);
         $q->bindParam(':batch', $c);
         $q->bindParam(':name', $d);
         $q->bindParam(':hometown', $g);
         $q->bindParam(':contact', $h);
         $q->bindParam(':email', $i);
         $q->bindParam(':sex', $j);
         $q->bindParam(':duration', $k);

    if ($q->execute()) {
        echo 200;
    } else {
        echo "Error updating student record.";
    }
} else {
    echo "Missing required fields.";
}
?>
