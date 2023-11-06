<?php
include('conn.php');

session_start();

$branch = $_SESSION['SESS_BRANCH'] ;
$position = $_SESSION['SESS_POSITION'] ;

if($position=='branch_admin' | $position=='counselor' ){
    $t_sql = "SELECT * FROM study_rooms WHERE branch='$branch'";
}

else{
// Query to select data from the users table
    $t_sql = "SELECT * FROM study_rooms ORDER BY id DESC";
}


try {
    // Total students
    $t_stmt = $db->prepare($t_sql);
    $t_stmt->execute();
    $total_branch = $t_stmt->rowCount();

    // Store the counts in an associative array
    $data = [
        "total" => $total_branch,
    ];

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
