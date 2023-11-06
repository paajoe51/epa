<?php
include('../conn.php');

// Check if the required POST fields are set
if (isset($_POST['username'], $_POST['password'], $_POST['full_name'], $_POST['position'], $_POST['branch'], $_POST['contact'], $_POST['email'])) {
    $a = $_POST['username'];
    $b = $_POST['password'];
    $c = $_POST['full_name'];
    $d = $_POST['position'];
    $e = $_POST['branch'];
    $f = $_POST['contact'];
    $g = $_POST['email'];
    $h = $_POST['description'];

    // Use prepared statements to prevent SQL injection
    $qry = $db->prepare("SELECT * FROM users WHERE username = :username AND email= :email" );
    $qry->bindParam(':username', $a);
    $qry->bindParam(':email', $g);
    $qry->execute();
    $uCount = $qry->rowCount();

    if ($uCount > 0) {
        echo 400;
    } else {
        // Use prepared statements for the INSERT query
        $sql = "INSERT INTO users (username, password, name, position, branch, contact, email, description) 
                VALUES (:username, :password, :name, :position, :branch, :contact, :email, :description)";

        $q = $db->prepare($sql);
        $q->bindParam(':username', $a);
        $q->bindParam(':password', $b);
        $q->bindParam(':name', $c);
        $q->bindParam(':position', $d);
        $q->bindParam(':branch', $e);
        $q->bindParam(':contact', $f);
        $q->bindParam(':email', $g);
        $q->bindParam(':description', $h);

        if ($q->execute()) {
            // Send email
            $to = "$g";
            $subject = 'IPMC - EPADAC Account Credentials';
            $message = "Hello,".$c." Your Credentials have been created on the Epadac IPMC management System  with the following details:\n\n";
            $message .= "Username: $a\n";
            $message .= "Position: $d\n";
            $message .= "Branch: $e\n";
            $message .= "Description: $h\n Kindly log in to admin.epadac.com with the provided Credentials, thank you.";
            
            $senderEmail = 'admin@epadac.com"';  // Change this to your desired sender email
            $senderName = 'EPADAC - IPMC ADMIN';  // Change this to your desired sender name

            $headers = "From: $senderName <$senderEmail>";

            mail($to, $subject, $message, $headers);

            echo 200;
        } else {
            echo "Error inserting user.";
        }
    }
} else {
    echo "Missing required fields.";
}
?>
