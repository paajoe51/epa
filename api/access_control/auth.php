<?php
// Start the session (if not started)
session_start();

// Check if the user is logged in
if (isset($_SESSION['SESS_ID'])) {
    // User is logged in
    echo 'logged_in';
} else {
    // User is not logged in
    echo 'not_logged_in';
}
?>
