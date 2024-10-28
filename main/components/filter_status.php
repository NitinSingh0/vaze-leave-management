<?php
session_start();
$_SESSION['staff_id'] = 123; // Example staff_id; replace with actual session data

// Database connection
include('../../config/connect.php');

// Fetch leave applications for the logged-in staff
$staff_id = $_SESSION['staff_id'];

// Initialize the leave approval status filter
$leave_status_filter = isset($_POST['leave_status']) ? $_POST['leave_status'] : '';

// Prepare the SQL query based on the filter
if ($leave_status_filter) {
    $status_query = "SELECT From_date AS from_date, To_date AS to_date, No_of_days AS no_of_days, 
                            Reason AS reason, Application_date AS application_date, 
                            leave_approval_status, A_year 
                     FROM d_cl_leave 
                     WHERE Staff_id = $staff_id AND leave_approval_status = '$leave_status_filter'";
} else {
    // Fetch all leave applications if no filter is selected
    $status_query = "SELECT From_date AS from_date, To_date AS to_date, No_of_days AS no_of_days, 
                            Reason AS reason, Application_date AS application_date, 
                            leave_approval_status, A_year 
                     FROM d_cl_leave 
                     WHERE Staff_id = $staff_id";
}

$status_result = $conn->query($status_query);

$leave_applications = [];
if ($status_result) {
    while ($row = $status_result->fetch_assoc()) {
        $leave_applications[] = $row;
    }
}

$conn->close();

// Return the results as JSON
header('Content-Type: application/json');
echo json_encode($leave_applications);
