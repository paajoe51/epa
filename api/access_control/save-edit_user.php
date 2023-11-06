<?php
include('../conn.php');

// Check if the required POST fields are set
if (isset($_POST['ID'])) {
    $id = $_POST['ID'];
    $a = $_POST['username'];
    $b = $_POST['password'];
    $c = $_POST['full_name'];
    $d = $_POST['position'];
    $f = $_POST['contact'];
    $g = $_POST['email'];

    // Use prepared statements for the UPDATE query
    $sql = "UPDATE users 
            SET username = :username, 
                password = :password, 
                name = :name, 
                position = :position, 
                contact = :contact, 
                email = :email
            WHERE id = :id";

    $q = $db->prepare($sql);
    $q->bindParam(':username', $a);
    $q->bindParam(':password', $b);
    $q->bindParam(':name', $c);
    $q->bindParam(':position', $d);
    $q->bindParam(':contact', $f);
    $q->bindParam(':email', $g);
    $q->bindParam(':id', $id); // Use $id instead of $g

    if ($q->execute()) {
        echo 200;
    } else {
        echo "Error updating user record.";
    }
} else {
    echo "Missing required fields.";
}
?>
