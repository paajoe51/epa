<?php
include('conn.php');
session_start();

//$branch = $_SESSION['SESS_BRANCH'];
$position = $_SESSION['SESS_POSITION'];

if ($position == 'branch_admin' || $position == 'counselor') {
    $branch = $_SESSION['SESS_BRANCH'];
    // Query to select data from the students table
    $sql = "SELECT * FROM students WHERE branch = '$branch' ORDER BY id DESC";
} elseif (!empty($_SESSION['SESS_BRANCH_OVRD']) && $_SESSION['SESS_BRANCH_OVRD'] == true && $_SESSION['SESS_BRANCH'] != 'all') {
    // Query to select data from the students table
    $branch = $_SESSION['SESS_BRANCH'];
    $sql = "SELECT * FROM students WHERE branch = '$branch' ORDER BY id DESC";
} elseif ($position == 'director' || $position == 'ops_manager') {
    // Query to select data from the students table
    $sql = "SELECT * FROM students ORDER BY id DESC";
} else {
    // Redirect to ../index.html when session position is not set
    header('Location: ../index.html');
    exit(); // Ensure that no further code is executed after redirection
}

try {
    $stmt = $db->prepare($sql);
    $stmt->execute();

    // Fetch data and store it in an array
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Count the number of rows
    $rowCount = count($data);

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
