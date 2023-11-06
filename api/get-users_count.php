<?php
include('conn.php');

$t_sql = "SELECT * FROM users";
$ad_sql = "SELECT * FROM users WHERE position = 'branch_admin'";
$co_sql = "SELECT * FROM users WHERE position = 'counselor'";

try {
    // Total students
    $t_stmt = $db->prepare($t_sql);
    $t_stmt->execute();
    $total_branch = $t_stmt->rowCount();

    // Total admins
    $ad_stmt = $db->prepare($ad_sql);
    $ad_stmt->execute();
    $total_admin = $ad_stmt->rowCount();

    // Total admins
    $co_stmt = $db->prepare($co_sql);
    $co_stmt->execute();
    $total_counselor = $co_stmt->rowCount();

    // Store the counts in an associative array
    $data = [
        "counselor" => $total_counselor,
        "admin" => $total_admin,
        "total" => $total_branch
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
