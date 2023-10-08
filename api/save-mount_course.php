<?php
include('conn.php');
$b = $_POST['course_code'];
$a = $_POST['course_name'];
$c = $_POST['description'];

  // query
  $sql = "INSERT INTO courses 
                          (name,code,description) 
                  VALUES (:a,:b,:c)";
  $q = $db->prepare($sql);
  $q->execute(array(':a'=>$a,':b'=>$b,':c'=>$c));

  if($q){
      echo 200;
  }
?>