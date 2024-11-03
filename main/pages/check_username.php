<?php
include("../../config/connect.php"); // Update this path to your database connection file

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    // Query to check if the username exists
    $sql = "SELECT * FROM staff WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "exists"; // Username already exists
    } else {
        echo "available"; // Username is available
    }
}
