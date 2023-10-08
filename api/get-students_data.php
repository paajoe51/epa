<?php
include('conn.php');

// Query to select data from the users table
$sql = "SELECT * FROM students ORDER BY id DESC";

try {
    $stmt = $db->prepare($sql);
    $stmt->execute();

    // Fetch data and store it in an array
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Count the number of rows
    $rowCount = count($data);

    // Append the row count to the JSON data
    $jsonDataWithCount = [
        "data" => $data,
        "rowCount" => $rowCount
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
