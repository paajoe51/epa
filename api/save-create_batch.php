<?php
session_start();
include('conn.php');
$a = $_POST['name'];
$b = $_POST['course'];
$c = $_POST['start_date'];
$d = $_POST['start_time'];
$e = $_POST['batch_room'];
$g = $_POST['max_number'];
$h = $_POST['comment'];
$i = $_SESSION['SESS_BRANCH'];
  // query
  $sql = "INSERT INTO batches 
                          (name,course,start_date, start_time, study_room, max_num, comment,branch) 
                  VALUES (:a,:b,:c, :d, :e, :g, :h, :i)";
  $q = $db->prepare($sql);
  $q->execute(array(':a'=>$a,':b'=>$b,':c'=>$c, ':d'=>$d, ':c'=>$c, ':d'=>$d, ':e'=>$e, ':g'=>$g, ':h'=>$h,':i'=>$i));

  if($q){
      echo 200;
  }
?>