<?php
include('conn.php');
session_start();

$branch = $_SESSION['SESS_BRANCH'] ;
$position = $_SESSION['SESS_POSITION'] ;
$currentYear = date("Y");

if($position=='branch_admin' || $position=='counselor' ){
    if (isset($_SESSION['SESS_BRANCH'])) {
    $s_branch = $_SESSION['SESS_BRANCH'];

    // Query to select data from the courses table
    $sql = "SELECT * FROM requests WHERE branch='$s_branch' AND YEAR(STR_TO_DATE(date, '%d/%m/%Y')) = $currentYear";
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
} else{
    // Query to select data from the courses table
    $sql = "SELECT * FROM requests";
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
}
?>