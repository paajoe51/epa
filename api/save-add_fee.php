<?php
include('conn.php');
$a = mt_rand(1, 50);
$b = $_POST['course_name'];
$c = $_POST['duration'];
$d = $_POST['amount'];

  // query
  $sql = "INSERT INTO fees_table 
                          (course_id,course_name,duration,amount) 
                  VALUES (:a,:b,:c,:d)";
  $q = $db->prepare($sql);
  $q->execute(array(':a'=>$a,':b'=>$b,':c'=>$c,':d'=>$d));

  if($q){
      echo 200;
  }
?>