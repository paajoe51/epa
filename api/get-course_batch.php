<?php
// Include your database connection file
include('conn.php');

if (isset($_POST['selected_course'])) {
    $selectedCourse = $_POST['selected_course'];

    // Prepare and execute the database query
    $sql = "SELECT DISTINCT name FROM batches WHERE course = :selectedCourse";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':selectedCourse', $selectedCourse, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch data and store it in an array
    $batches = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Add "GB(L0)" as the first object in the array
    array_unshift($batches, "GB(L0)");

    // Return the response as JSON
    $response = ['batches' => $batches];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
