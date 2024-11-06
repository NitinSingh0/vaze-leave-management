<?php
// Start the session
session_start();
$staff_id = $_SESSION['Staff_id']; // Use session data for the logged-in staff ID

if (!isset($_SESSION['Staff_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}
// Database connection
include('../../config/connect.php');
?>
<h1> Update page here</h1>