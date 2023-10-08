<?php
include('conn.php');

// Query to select data from the branches table
$sql = "SELECT * FROM branches";

try {
    $stmt = $db->prepare($sql);
    $stmt->execute();

    // Fetch data and store it in an array
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Iterate through each branch and count the number of students
    foreach ($data as &$branch) {
        $branchName = $branch['name'];

        // Query to count the number of students with the same name in the students table
        $countSql = "SELECT COUNT(*) as num_students FROM students WHERE branch = :branchName";
        $br_countStmt = $db->prepare($countSql);
        $br_countStmt->bindParam(':branchName', $branchName, PDO::PARAM_STR);
        $br_countStmt->execute();

        // Fetch the count and append it to the branch data
        $countResult = $br_countStmt->fetch(PDO::FETCH_ASSOC);
        $branch['num_students'] = $countResult['num_students'];

        // Query to count the number of students with the same name in the students table
        $uCountSql = "SELECT COUNT(*) as num_staff FROM users WHERE branch = :branchName";
        $u_countStmt = $db->prepare($uCountSql);
        $u_countStmt->bindParam(':branchName', $branchName, PDO::PARAM_STR);
        $u_countStmt->execute();

        // Fetch the count and append it to the branch data
        $ucountResult = $u_countStmt->fetch(PDO::FETCH_ASSOC);
        $branch['num_staff'] = $ucountResult['num_staff'];
    }

    // Encode the modified data as JSON
    $json_data = json_encode($data);

    // Output the JSON data
    header('Content-Type: application/json');
    echo $json_data;
} catch (PDOException $e) {
    // Handle query error
    echo "Error: " . $e->getMessage();
}

?>