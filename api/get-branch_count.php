<?php
include('conn.php');

$t_sql = "SELECT * FROM branches";

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
