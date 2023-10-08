<?php
/* Database config */
$db_host		= '127.0.0.1';
$db_user		= 'root';
$db_pass		= '';
$db_database	= 'epa_ipmc_db'; 

/* Database config

$db_host		= '23.111.175.170';
$db_user		= 'mickysof_root';
$db_pass		= 'paajoe@1992';
$db_database	= 'mickysof_momo_rec_db';  */
try {
	//create PDO connection
	$db = new PDO('mysql:host='.$db_host.';dbname='.$db_database, $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Suggested to comment on production websites
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    //echo "db connected";

} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    echo"error  test message";
    exit;
}

?>