<?php
session_start();
$staff_id = $_SESSION['Staff_id']; // Use session data for the logged-in staff ID

// Database connection
include('../../config/connect.php');

// Get filter values from POST request
$leave_status = isset($_POST['leave_status']) ? $_POST['leave_status'] : '';
$academic_year = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
$leave_type = isset($_POST['leave_type']) ? $_POST['leave_type'] : '';
$from_date = isset($_POST['from_date']) ? $_POST['from_date'] : '';

// Prepare the base query
$query = "SELECT From_date AS from_date, To_date AS to_date, No_of_days AS no_of_days, 
                 Reason AS reason, Date_of_application AS Date_of_application, 
                 leave_approval_status, A_year, 'CL' AS leave_type
                 FROM d_cl_leave 
                 WHERE Staff_id = $staff_id
                 UNION ALL
                 SELECT From_date, To_date, No_of_days, Date_of_application, Nature AS reason, 
                 leave_approval_status, A_year, 'DL' AS leave_type 
                 FROM d_dl_leave 
                 WHERE Staff_id = $staff_id";

// Add conditions based on filters
if ($leave_status) {
    $query .= " AND leave_approval_status = '$leave_status'";
}
if ($academic_year) {
    $query .= " AND A_year = '$academic_year'";
}
if ($leave_type) {
    $query .= " AND leave_type = '$leave_type'";
}
if ($from_date) {
    $query .= " AND From_date >= '$from_date'";
}

// Execute the query
$result = $conn->query($query);
$leave_applications = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $leave_applications[] = $row;
    }
}

// Return the result as JSON
echo json_encode($leave_applications);

// Close the connection
$conn->close();
