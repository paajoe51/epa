<?php
session_start();

// Your authentication logic goes here
if (isset($_SESSION['username'])) {
    // User is logged in
    echo 'authenticated';
} else {
    // User is not logged in
    echo 'not_authenticated';
}
?>
