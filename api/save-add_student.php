<?php
include('conn.php');

if(empty($_POST['reg_fee'])){
  echo 401;
}
elseif($_POST['reg_fee']<350){
    echo 402;
}
// Check if the required POST fields are set
 elseif (isset($_POST['student_id'], $_POST['course'],$_POST['course_duration'], $_POST['batch'], $_POST['name'], $_POST['branch'], $_POST['dob'], $_POST['reg_fee'])) {
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
    $l = $_POST['sp_name'];
    $m = $_POST['sp_contact'];
    $n = $_POST['reg_fee'];

    // Use prepared statements to prevent SQL injection
    $qry = $db->prepare("SELECT * FROM students WHERE student_id = :student_id AND contact = :contact");
    $qry->bindParam(':student_id', $a);
    $qry->bindParam(':contact', $h);
    $qry->execute();
    $uCount = $qry->rowCount();

    if ($uCount > 0) {
        echo 400;
    } else {
        // Use prepared statements for the INSERT query
        $sql = "INSERT INTO students (student_id, course, course_duration, batch, name, branch, dob, hometown, contact, email, sex, sponsor, sponsor_contact, payment_status)
                VALUES (:student_id, :course, :duration, :batch, :name, :branch, :dob, :hometown, :contact, :email, :sex, :spon, :spon_con, :reg_fee)";

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
            $q->bindParam(':spon', $l);
            $q->bindParam(':spon_con', $m);
            $q->bindParam(':reg_fee', $n);

        if ($q->execute()) {
            $number = ['233' . substr($h, 1)];
            $subject = 'EPADAC IPMC - New Expenditure  Request';    
            $message = "Hello  $d,  \nYou have been Successfully Enrolled in IPMC - $e Branch, to read $b for the Duration of $k.\nYour Student ID is $a";
            include('send-sms.php');
            $number = ['233' . substr($m, 1)];
            $subject = 'EPADAC IPMC - New Expenditure  Request';    
            $message = "Hello  $l,  \nThank you for Enrolling your ward at  IPMC - $e Branch, to read $b for the Duration of $k.";
            include('send-sms.php');
            echo 200;
        } else {
            echo "Error inserting user.";
        }
    }
} else {
    echo "Missing required fields.";
}
?>