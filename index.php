<?php
require_once 'includes/functions.php';

startSession();

// Redirect based on login status
if (isLoggedIn()) {
    redirect('dashboard.php');
} else {
    redirect('login.php');
}
?>

