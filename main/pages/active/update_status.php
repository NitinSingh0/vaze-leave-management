
<?php
// update_status.php
include("../../../config/connect.php"); // Include your database connection

if (isset($_POST['staff_id']) && isset($_POST['status'])) {
    $staff_id = $_POST['staff_id'];
    $newstatus = $_POST['status'];

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
