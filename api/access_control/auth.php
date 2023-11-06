<?php
session_start();
if(isset($_SESSION['SESS_POSITION'])){
    $position = $_SESSION['SESS_POSITION'] ;

    if($position!='director' ){
        echo 401;
    }
    else{
        echo 200;
        }
    }
else{
    echo 401;
}
?>