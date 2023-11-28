<?php
include('conn.php');
session_start();
$position = $_SESSION['SESS_POSITION'] ;

if($position=='branch_admin' | $position=='counselor' ){
    $branch = $_SESSION['SESS_BRANCH'] ;
    // Query to select data from the students table
    $sql = "SELECT * FROM fees WHERE branch = '$branch' ORDER BY id DESC";
}elseif (!empty($_SESSION['SESS_BRANCH_OVRD']) && $_SESSION['SESS_BRANCH_OVRD'] == true && $_SESSION['SESS_BRANCH']!='all') {
    // Query to select data from the students table
    $branch = $_SESSION['SESS_BRANCH'] ;
    $sql = "SELECT * FROM fees WHERE branch = '$branch' ORDER BY id DESC";
}else {
   // Query to select data from the students table
    $sql = "SELECT * FROM fees ORDER BY id DESC";
}


try {
    $stmt = $db->prepare($sql);
    $stmt->execute();

    // Fetch data and store it in an array
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Encode the data as JSON
    $json_data = json_encode($data);

    // Output the JSON data
    header('Content-Type: application/json');
    echo $json_data;
} catch (PDOException $e) {
    // Handle query error
    echo "Error: " . $e->getMessage();
}
?>