<?php
include('conn.php');

// Query to select data from the courses table
$sql = "SELECT courses.name AS name, courses.id, courses.code,  courses.description, fees_table.amount, fees_table.duration
        FROM courses
        LEFT JOIN fees_table ON courses.id = fees_table.course_id"; // Assuming there's a relationship between courses and fees through 'id' and 'course_id'

try {
    $stmt = $db->prepare($sql);
    $stmt->execute();

    // Fetch data and store it in an array
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as &$branch) {
        $courseName = $branch['name'];

        // Query to count the number of students with the same name in the students table
        $countSql = "SELECT COUNT(*) as num_students FROM students WHERE course = :courseName";
        $course_countStmt = $db->prepare($countSql);
        $course_countStmt->bindParam(':courseName', $courseName, PDO::PARAM_STR);
        $course_countStmt->execute();

        // Fetch the count and append it to the branch data
        $countResult = $course_countStmt->fetch(PDO::FETCH_ASSOC);
        $branch['num_students'] = $countResult['num_students'];
    }

    // Output the JSON data
    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    // Handle query error
    echo "Error: " . $e->getMessage();
}
?>
