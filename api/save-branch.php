<?php
include('conn.php');
$a = $_POST['branch_name'];
$b = $_POST['location'];
$c = $_POST['address'];

  // query
  $sql = "INSERT INTO branches 
                          (name,location,address) 
                  VALUES (:a,:b,:c)";
  $q = $db->prepare($sql);
  $q->execute(array(':a'=>$a,':b'=>$b,':c'=>$c));

  if($q){
      echo 200;
  }
?>