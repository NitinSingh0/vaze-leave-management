<?php
// update_status.php
include("../../../config/connect.php"); // Include your database connection

session_start();
$Staff_id = $_SESSION['Staff_id'];
//echo "console.log(" . $Staff_id . ")";

if (!$Staff_id) {
    echo "<script>alert('User not logged in.'); window.location.href='login.php';</script>";
    exit;
}

if (isset($_POST['staff_id']) && isset($_POST['status'])) {
    $staff_id = $_POST['staff_id'];
    $newstatus= $_POST['status'];

    $action = $newstatus === 'A' ? 'Activate' : 'Deactivate';
    $action_performed_by=$Staff_id;
    $log_query = "INSERT INTO user_status_logs (staff_id, action_performed_by, action) VALUES (?, ?, ?)";
    $log_stmt = $conn->prepare($log_query);
    $log_stmt->bind_param('iis', $staff_id, $action_performed_by, $action);
    $log_stmt->execute();

        // Update query
        $query = "UPDATE staff SET status = '$newstatus' WHERE Staff_id = '$staff_id'";
        if ($conn->query($query) === TRUE) {
            echo "success";
        } else {
            echo "error";
        }


   

} else {
    echo "invalid";
}
