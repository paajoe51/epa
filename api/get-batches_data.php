<?php
include('conn.php');
session_start();
$branch = $_SESSION['SESS_BRANCH'] ;
$position = $_SESSION['SESS_POSITION'] ;

if($position=='branch_admin' | $position=='counselor' ){
    $t_sql = "SELECT * FROM batches WHERE branch='$branch'";
}
else{
    $t_sql = "SELECT * FROM batches";
}

// Query to select data from the batches table
$sqlBatches = "SELECT * FROM batches";

// Query to count the total number of batches
$countBatchesSql = "SELECT COUNT(*) as total FROM batches";

try {
    // Fetch data and store it in an array
    $stmtBatches = $db->prepare($sqlBatches);
    $stmtBatches->execute();
    $data = $stmtBatches->fetchAll(PDO::FETCH_ASSOC);

    // Count total batches
    $stmtTotalBatches = $db->prepare($countBatchesSql);
    $stmtTotalBatches->execute();
    $totalBatches = $stmtTotalBatches->fetchColumn();

    // Add total batches to the array with index 'summary'
    $data['summary'] = array('name' => 'Total Batches', 'total' => $totalBatches);

    // Iterate through the batches and find the number of students for each batch
    foreach ($data as &$batch) {
        if (!is_array($batch) || !array_key_exists('name', $batch)) {
            continue; // Skip elements that are not batches
        }

        $batchName = $batch['name']; // Store the batch name in a separate variable

        // Query to count the number of students in the students table for a specific batch
        $countSql = "SELECT COUNT(*) as students FROM students WHERE batch = :batch";

        $countStmt = $db->prepare($countSql);
        $countStmt->bindParam(':batch', $batchName, PDO::PARAM_STR);
        $countStmt->execute();

        // Fetch the count and update the array
        $numStudents = $countStmt->fetchColumn();
        $batch['students'] = $numStudents;
    }

    // Encode the updated data as JSON
    $json_data = json_encode($data);

    // Output the JSON data
    header('Content-Type: application/json');
    echo $json_data;
} catch (PDOException $e) {
    // Handle query error
    echo "Error: " . $e->getMessage();
}
?>
