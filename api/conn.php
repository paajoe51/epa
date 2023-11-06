
<?php
/* Connection parameters - Remote
$db_host = '94.23.253.103';
$db_port = '3306';
$db_name = 'epadacco_ipmc_admin';
$db_user = 'epadacco_mickysoft';
$db_pass = 'PAAjoe@1992';*/

// Connection parameters - Local
$db_host = '127.0.0.1';
$db_port = '3306';
$db_name = 'epa_ipmc_db';
$db_user = 'root';
$db_pass = '';


// PDO connection string
$dsn = "mysql:host=$db_host;port=$db_port;dbname=$db_name";

try {
    // Create a new PDO instance
    $db = new PDO($dsn, $db_user, $db_pass);

    // Set PDO to throw exceptions on error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //echo 'Connection successful'; // This line should be executed if the connection is successful

} catch (PDOException $e) {
    // Handle PDO connection error
    die("Connection failed: " . $e->getMessage());
}
?>
