<?php
// Assuming you have a database connection established
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['room_id'])) {
    $roomId = $_POST['room_id'];

    // Perform the deletion query
    $query = "DELETE FROM study_rooms WHERE id = :room_id";
    $statement = $db->prepare($query);
    $statement->bindParam(':room_id', $roomId, PDO::PARAM_INT);

    if ($statement->execute()) {
        echo 'Room deleted successfully';
    } else {
        http_response_code(500); // Server error
        echo 'Error deleting room';
    }
} else {
    http_response_code(400); // Bad request
    echo 'Invalid request';
}
?>
