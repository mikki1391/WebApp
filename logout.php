<?php
require_once 'includes/functions.php';

// Unset session variables and destroy the session
if (isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    session_destroy();
}

// Redirect to the login page
header("Location: login.php");
exit();
?>
