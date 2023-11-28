<?php
// set-session_branch.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the selected branch from the AJAX request
    $selectedBranch = isset($_POST['selected_branch']) ? $_POST['selected_branch'] : '';

    // Store the selected branch in the session
    session_start();
    $_SESSION['SESS_BRANCH'] = $selectedBranch;
    $_SESSION['SESS_BRANCH_OVRD'] = true;
    // Send a response (you can customize this based on your needs)
    echo 'Branch set successfully';
} else {
    // Handle invalid requests
    http_response_code(400);
    echo 'Invalid request';
}
?>