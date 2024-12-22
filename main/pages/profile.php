<?php
session_start();
include '../../config/connect.php'; // Include your DB connection file

// Check if staff_id is in the session
if (isset($_SESSION['Staff_id'])) {
    $staff_id = $_SESSION['Staff_id'];
    if (!isset($_SESSION['Staff_id'])) {
        // Redirect to login page if not logged in
        header("Location: login.php");
        exit();
    }

    // Query to fetch staff data
    $sql = "SELECT s.Name, s.Username, s.Job_role Role, s.Designation, s.DOJ Date_of_Joining, d.Name Department_name 
            FROM staff s
            INNER JOIN department d ON s.D_id = d.D_id
            WHERE s.Staff_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data); // Output data as JSON
    } else {
        echo json_encode(["error" => "No staff data found."]);
    }
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "User not logged in."]);
}
?>