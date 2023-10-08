<?php
include('conn.php');


$qry = $db->prepare("SELECT * FROM courses ");

function getCourses($q){
    $q->execute();
    for ($i=1; $row=$q->fetch(); $i++) {
        $courses[] = array("id"=>$row['id'],"course_name"=> $row['name'] );
    
    }
    return $courses;
}

echo json_encode(getCourses($qry));

?>