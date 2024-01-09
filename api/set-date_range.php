<?php
// set-session_date_range.php
session_start();

$currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the selected date range from the AJAX request
    if (isset($_POST['date_range'])) {
         $_SESSION['SESS_DATE_START'] = $_POST['begin'];;
         $_SESSION['SESS_DATE_END'] = $_POST['finish'];;

        // Store the selected date range in the session
        $_SESSION['SESS_DATE_RANGE'] = $_POST['date_range'];
        echo 200;
        exit();
    } else {
        // Handle invalid requests
        http_response_code(400);
        echo 'Invalid request';
    }
} else {
    // Handle invalid requests
    http_response_code(400);
    echo 'Invalid request';
}

echo "Current URL: $currentURL";
?>
