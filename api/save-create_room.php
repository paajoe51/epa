<?php
include('conn.php');
$a = $_POST['room_name'];
$b = $_POST['room_description'];
$c =$_POST['room_id'];

  // query
  $sql = "INSERT INTO study_rooms 
                          (room_name,room_description,room_id) 
                  VALUES (:a,:b,:c)";
  $q = $db->prepare($sql);
  $q->execute(array(':a'=>$a,':b'=>$b,':c'=>$c));

  if($q){
      echo 200;
  }
?>