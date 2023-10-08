<?php
include('conn.php');

// Query to select data from the students table
$t_sql = "SELECT * FROM students";
$m_sql = "SELECT * FROM students WHERE sex = 'male'";
$f_sql = "SELECT * FROM students WHERE sex = 'female'";

try {
    // Total students
    $t_stmt = $db->prepare($t_sql);
    $t_stmt->execute();
    $total_students = $t_stmt->rowCount();

    // Male students
    $m_stmt = $db->prepare($m_sql);
    $m_stmt->execute();
    $male_students = $m_stmt->rowCount();

    // Female students
    $f_stmt = $db->prepare($f_sql);
    $f_stmt->execute();
    $female_students = $f_stmt->rowCount();

    // Store the counts in an associative array
    $data = [
        "total" => $total_students,
        "males" => $male_students,
        "females" => $female_students
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
