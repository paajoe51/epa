<?php
include('conn.php');
session_start();
$currentYear = date("Y");

// Check if required session variables are set
if (isset($_SESSION['SESS_BRANCH'], $_SESSION['SESS_POSITION'])) {
    $branch = $_SESSION['SESS_BRANCH'];
    $position = $_SESSION['SESS_POSITION'];

    if ($position == 'branch_admin' || $position == 'counselor') {
        $sql = "SELECT * FROM requests 
                WHERE type='earlier' AND branch = :branch AND YEAR(STR_TO_DATE(date, '%d/%m/%Y')) = $currentYear";
    } else {
        // Check if SESS_BRANCH_OVRD is set
        if (isset($_SESSION['SESS_BRANCH_OVRD']) && $_SESSION['SESS_BRANCH_OVRD'] == true && $branch!='all') {
            $sql = "SELECT * FROM requests 
                    WHERE type='earlier' AND branch = :branch";
        } else {
            $sql = "SELECT * FROM requests 
                    WHERE type='earlier'";
        }
    }

    try {
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':branch', $branch, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch data and store it in an array
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Encode the data as JSON
        $json_data = json_encode($data);

        // Output the JSON data
        header('Content-Type: application/json');
        echo $json_data;
    } catch (PDOException $e) {
        // Handle query error
        echo "Error: " . $e->getMessage();
    }
}else{
    echo 'Something went wrong';
}

?>