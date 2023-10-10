<?php
session_start();
$branch = $_SESSION['SESS_BRANCH'] ;
$position = $_SESSION['SESS_POSITION'] ;

if($position!='director' ){
    echo 401;
}

else{
echo 200;

}

?>